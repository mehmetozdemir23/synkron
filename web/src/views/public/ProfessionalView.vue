<template>
  <div class="min-h-screen flex flex-col bg-neutral-50">
    <PublicHeader />

    <main class="flex-1 flex flex-col py-4 sm:py-6 md:py-8">
      <LoadingState v-if="loading" />
      <ErrorState v-else-if="error" :error="error" />

      <div
        v-else
        class="flex-1 flex flex-col max-w-3xl mx-auto w-full px-3 sm:px-4 md:px-6"
      >
        <ProfessionalCard :professional="professional" />

        <UnavailableAlert
          v-if="professional.can_accept_bookings === false"
          class="mt-5"
        />

        <div v-else class="mt-5 sm:mt-6 flex-1 flex flex-col min-h-0">
          <StepIndicator :current-step="currentStep" class="mb-6 sm:mb-8" />

          <div
            class="bg-neutral-100 border border-neutral-200 rounded-2xl flex flex-col flex-1 overflow-hidden shadow-sm"
          >
            <div class="p-4 sm:p-6 md:p-8 flex-1 overflow-y-auto">
              <Transition name="fade-slide" mode="out-in">
                <StepService
                  v-if="currentStep === 1"
                  :services="services"
                  :selected-service="selectedService"
                  @select-service="handleServiceSelect"
                />

                <StepSlots
                  v-else-if="currentStep === 2"
                  :slots-by-day="slotsByDay"
                  :selected-day-index="selectedDayIndex"
                  :selected-slot="selectedSlot"
                  :selected-service="selectedService"
                  :professional-timezone="professional.timezone"
                  :loading="loadingSlots"
                  @select-day="selectedDayIndex = $event"
                  @select-slot="selectedSlot = $event"
                />

                <StepInfo
                  v-else-if="currentStep === 3"
                  v-model:client-name="bookingData.client_name"
                  v-model:client-email="bookingData.client_email"
                  v-model:notes="bookingData.notes"
                />
              </Transition>
            </div>

            <BookingActions
              :current-step="currentStep"
              :selected-service="selectedService"
              :selected-slot="selectedSlot"
              :booking-in-progress="bookingInProgress"
              @go-to-step="handleGoToStep"
              @create-booking="handleCreateBooking"
            />
          </div>
        </div>
      </div>
    </main>

    <AppFooter />
  </div>
</template>

<script setup>
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import LoadingState from "@/components/booking/LoadingState.vue";
import ErrorState from "@/components/booking/ErrorState.vue";
import ProfessionalCard from "@/components/booking/ProfessionalCard.vue";
import UnavailableAlert from "@/components/booking/UnavailableAlert.vue";
import StepIndicator from "@/components/booking/StepIndicator.vue";
import StepService from "@/components/booking/StepService.vue";
import StepSlots from "@/components/booking/StepSlots.vue";
import StepInfo from "@/components/booking/StepInfo.vue";
import BookingActions from "@/components/booking/BookingActions.vue";
import { ref, computed, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { publicAPI } from "@/services/api";
import { useToastStore } from "@/stores/toast";
import { useFormatters } from "@/composables/useFormatters";
import { logError } from "@/utils/logger";

const SLOTS_RANGE_DAYS = 30;

const route = useRoute();
const router = useRouter();
const toastStore = useToastStore();

const loading = ref(true);
const error = ref("");
const professional = ref({});
const services = ref([]);

const currentStep = ref(1);
const selectedService = ref(null);
const selectedSlot = ref(null);
const selectedDayIndex = ref(0);
const bookingData = ref({
  client_name: "",
  client_email: "",
  notes: "",
});
const bookingInProgress = ref(false);

const loadingSlots = ref(false);
const slots = ref([]);

const slotsByDay = computed(() => {
  if (!slots.value?.length) return [];

  return groupSlotsByDay(slots.value);
});

function groupSlotsByDay(slots) {
  const groups = {};

  slots.forEach((slot) => {
    const date = new Date(slot.start_at);
    const dateKey = date.toISOString().split("T")[0];

    if (!groups[dateKey]) {
      groups[dateKey] = { date: dateKey, dateObj: date, slots: [] };
    }

    groups[dateKey].slots.push(slot);
  });

  return Object.values(groups)
    .sort((a, b) => a.dateObj.getTime() - b.dateObj.getTime())
    .map((group) => ({
      date: group.date,
      dayName: formatDayName(group.dateObj),
      dayNumber: formatDayNumber(group.dateObj),
      fullDate: formatFullDate(group.dateObj),
      slotsCount: group.slots.length,
      slots: group.slots,
    }));
}

const { formatDayName, formatDayNumber, formatFullDate } = useFormatters();

async function loadProfessional() {
  loading.value = true;

  try {
    const response = await publicAPI.getProfessional(route.params.slug);
    professional.value = response.data.professional;
    services.value = response.data.services;
  } catch (err) {
    error.value = "Professionnel non trouvé";
  } finally {
    loading.value = false;
  }
}

async function loadSlots() {
  if (!selectedService.value) return;

  loadingSlots.value = true;

  try {
    const today = new Date();
    const endDate = new Date();
    endDate.setDate(endDate.getDate() + SLOTS_RANGE_DAYS);

    const response = await publicAPI.getAvailableSlots(
      route.params.slug,
      selectedService.value.id,
      {
        start_date: today.toISOString().split("T")[0],
        end_date: endDate.toISOString().split("T")[0],
      }
    );

    slots.value = response.data.slots;
  } catch (err) {
    logError("ProfessionalView.loadSlots", err);
    toastStore.error("Erreur lors du chargement des créneaux");
  } finally {
    loadingSlots.value = false;
  }
}

function handleServiceSelect(service) {
  selectedService.value = service;
  loadSlots();
}

async function handleGoToStep(step) {
  if (step === 2 && !slots.value.length) {
    await loadSlots();
  }

  currentStep.value = step;

  if (step === 2) {
    resetSlotSelection();
  }
}

function resetSlotSelection() {
  selectedSlot.value = null;
  selectedDayIndex.value = 0;
}

async function handleCreateBooking() {
  if (!isBookingDataValid()) {
    toastStore.error("Veuillez remplir tous les champs obligatoires");
    return;
  }

  bookingInProgress.value = true;

  try {
    const response = await publicAPI.createBooking(
      route.params.slug,
      selectedService.value.id,
      {
        ...bookingData.value,
        start_at: selectedSlot.value.start_at,
      }
    );

    await router.push({
      name: "booking-confirmation",
      query: {
        booking_id: response.data.booking.id,
      },
    });
  } catch (err) {
    const errorMessage =
      err.response?.data?.message || "Erreur lors de la réservation";
    toastStore.error(errorMessage);
  } finally {
    bookingInProgress.value = false;
  }
}

function isBookingDataValid() {
  return (
    selectedSlot.value &&
    bookingData.value.client_name &&
    bookingData.value.client_email
  );
}

onMounted(() => {
  loadProfessional();
});
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(8px);
}
</style>
