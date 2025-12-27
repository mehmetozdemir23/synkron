<template>
  <div class="space-y-4">
    <div class="bg-neutral-100 rounded-xl shadow-md overflow-hidden">
      <div class="py-4 px-4" v-memo="[pendingCount, currentDate]">
        <div class="lg:hidden space-y-3">
          <div class="flex items-center justify-between">
            <button
              @click="previousMonth"
              class="p-1.5 rounded-full hover:bg-neutral-200"
            >
              <ChevronLeft class="w-5 h-5 text-neutral-700" />
            </button>

            <h3 class="capitalize text-lg font-medium text-neutral-900">
              {{ formatMonthYear(currentDate) }}
            </h3>

            <button
              @click="nextMonth"
              class="p-1.5 rounded-full hover:bg-neutral-200"
            >
              <ChevronRight class="w-5 h-5 text-neutral-700" />
            </button>
          </div>

          <div v-if="pendingCount > 0" class="flex justify-center">
            <button
              @click="showPendingModal = true"
              class="flex items-center gap-2 text-xs bg-warning-300 text-warning-800 rounded-full px-3 pt-1.5 pb-1 min-h-0"
            >
              <span class="w-1.5 h-1.5 bg-warning-500 rounded-full"></span>
              <span class="mb-1 sm:mb-0">{{ pendingCount }} en attente</span>
              <ArrowRight class="icon-xs" />
            </button>
          </div>
        </div>

        <div class="hidden lg:flex items-center justify-between">
          <div class="flex items-center gap-3">
            <h3 class="capitalize text-lg font-medium text-neutral-900">
              {{ formatMonthYear(currentDate) }}
            </h3>
            <PendingBookingsBadge
              v-if="pendingCount > 0"
              :pending-count="pendingCount"
              icon-size="sm"
              :show-full-text="true"
              @show-pending-modal="showPendingModal = true"
            />
          </div>

          <div class="flex gap-1">
            <button
              @click="previousMonth"
              class="p-2 rounded-full hover:bg-neutral-200"
            >
              <ChevronLeft class="icon-md text-neutral-700" />
            </button>
            <button
              @click="nextMonth"
              class="p-2 rounded-full hover:bg-neutral-200"
            >
              <ChevronRight class="icon-md text-neutral-700" />
            </button>
          </div>
        </div>
      </div>

      <div class="hidden lg:block px-4 pb-4">
        <div class="grid grid-cols-7 mb-2">
          <div
            v-for="day in dayLabels"
            :key="day"
            class="text-center text-xs font-medium uppercase text-neutral-600 py-2"
          >
            {{ day }}
          </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-7 gap-2">
          <div
            v-for="i in 42"
            :key="i"
            class="h-32 rounded-lg bg-neutral-200 animate-pulse"
          ></div>
        </div>

        <div v-else class="grid grid-cols-7 gap-2">
          <div
            v-for="day in allDays"
            :key="day.date.toISOString()"
            :class="[
              'h-32 rounded-lg p-2 transition-colors',
              day.isCurrentMonth
                ? 'bg-neutral-100 hover:bg-neutral-200'
                : 'bg-neutral-50',
            ]"
          >
            <div
              :class="[
                'text-sm font-medium mb-1',
                day.isCurrentMonth ? 'text-neutral-900' : 'text-neutral-400',
              ]"
            >
              {{ day.dayOfMonth }}
            </div>

            <div class="space-y-1">
              <div
                v-for="booking in getBookingsForDay(day.date).slice(0, 2)"
                :key="booking.id"
                @click="selectBooking(booking)"
                :class="[
                  'text-xs px-2 py-1 rounded-full truncate cursor-pointer font-medium',
                  booking.status === 'pending'
                    ? 'bg-warning-200 text-warning-900'
                    : 'bg-success-200 text-success-900',
                ]"
              >
                {{ formatTime(booking.start_at) }}
                {{ booking.service.name }}
              </div>

              <button
                v-if="getBookingsForDay(day.date).length > 2"
                @click="showDayBookings(day.date)"
                class="text-xs text-brand-700 px-2 font-medium hover:underline"
              >
                +{{ getBookingsForDay(day.date).length - 2 }} autre{{
                  getBookingsForDay(day.date).length - 2 > 1 ? "s" : ""
                }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:hidden px-4 pb-4">
        <div
          v-if="upcomingBookings.length === 0"
          class="text-center py-12 text-neutral-600"
        >
          <p class="text-sm font-medium">Aucune réservation ce mois</p>
        </div>

        <div v-else class="space-y-2 max-h-[500px] overflow-y-auto">
          <div
            v-for="booking in upcomingBookings"
            :key="booking.id"
            @click="selectBooking(booking)"
            class="p-3 rounded-lg bg-neutral-100 hover:bg-neutral-200 cursor-pointer"
          >
            <p class="text-sm font-medium text-neutral-900">
              {{ booking.service.name }}
            </p>
            <p class="text-xs text-neutral-600 mt-1">
              {{ formatDateShort(booking.start_at) }} •
              {{ formatTime(booking.start_at) }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <BaseModal
      :show="showPendingModal"
      @close="showPendingModal = false"
      title="Réservations en attente"
    >
      <PendingBookings
        :bookings="props.bookings.filter((b) => b.status === 'pending')"
        @booking-updated="handleBookingUpdated"
      />
    </BaseModal>

    <BaseModal
      :show="!!selectedBooking"
      @close="selectedBooking = null"
      :title="selectedBooking?.service.name || ''"
      size="sm"
    >
      <div v-if="selectedBooking" class="space-y-5">
        <div>
          <span
            :class="getStatusBadgeClass(selectedBooking.status)"
            class="px-3 py-1.5 rounded-lg text-xs font-semibold"
          >
            {{ getStatusLabel(selectedBooking.status) }}
          </span>
        </div>

        <div class="space-y-3">
          <div>
            <p class="text-sm font-semibold text-neutral-900">
              {{ formatDateFull(selectedBooking.start_at) }}
            </p>
            <p class="text-sm text-neutral-600 mt-0.5">
              {{ formatTime(selectedBooking.start_at) }}
            </p>
          </div>

          <div>
            <p class="text-sm font-semibold text-neutral-900">
              {{ selectedBooking.client_name }}
            </p>
            <p class="text-sm text-neutral-600 mt-0.5 truncate">
              {{ selectedBooking.client_email }}
            </p>
          </div>
        </div>

        <div
          v-if="selectedBooking.status === 'pending'"
          class="flex gap-2 pt-2 border-t border-neutral-200"
        >
          <button
            @click="handleAcceptBooking(selectedBooking)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-success-500 text-white rounded-lg hover:bg-success-600 active:bg-success-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium text-sm transition-smooth"
          >
            <Check class="w-4 h-4" />
            Accepter
          </button>
          <button
            @click="handleRejectBooking(selectedBooking)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-error-500 text-white rounded-lg hover:bg-error-600 active:bg-error-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium text-sm transition-smooth"
          >
            <X class="w-4 h-4" />
            Refuser
          </button>
        </div>
      </div>
    </BaseModal>

    <BaseModal
      :show="!!selectedDayDate"
      @close="selectedDayDate = null"
      :title="selectedDayDate ? formatDateFull(selectedDayDate) : ''"
    >
      <div v-if="selectedDayDate" class="space-y-2">
        <div
          v-for="booking in getBookingsForDay(selectedDayDate)"
          :key="booking.id"
          @click="
            selectedDayDate = null;
            selectBooking(booking);
          "
          class="p-3 rounded-lg bg-neutral-100 hover:bg-neutral-200 cursor-pointer transition-smooth"
        >
          <div class="flex items-center justify-between mb-1.5">
            <p class="text-sm font-semibold text-neutral-900">
              {{ booking.service.name }}
            </p>
            <span
              :class="getStatusBadgeClass(booking.status)"
              class="px-2.5 py-1 rounded-lg text-xs font-semibold"
            >
              {{ getStatusLabel(booking.status) }}
            </span>
          </div>
          <p class="text-xs text-neutral-600">
            {{ formatTime(booking.start_at) }} • {{ booking.client_name }}
          </p>
        </div>
      </div>
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import {
  ChevronLeft,
  ChevronRight,
  X,
  Check,
  ArrowRight,
} from "lucide-vue-next";
import BaseModal from "@/components/ui/BaseModal.vue";
import PendingBookings from "@/components/dashboard/PendingBookings.vue";
import { useBookingsStore } from "@/stores/bookings";
import { useAlertStore } from "@/stores/alert";
import { useFormatters } from "@/composables/useFormatters";
import { useStatusClasses } from "@/composables/useStatusClasses";
import PendingBookingsBadge from "./PendingBookingsBadge.vue";

const { formatTime, formatDateShort, formatDateFull, formatMonthYear } =
  useFormatters();
const { getStatusBadgeClass, getStatusLabel } = useStatusClasses();

const bookingsStore = useBookingsStore();
const alertStore = useAlertStore();
const actionInProgress = ref(false);

const props = defineProps({
  bookings: {
    type: Array,
    required: true,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["refresh", "month-changed"]);

const currentDate = ref(new Date());
const selectedBooking = ref(null);
const showPendingModal = ref(false);
const selectedDayDate = ref(null);

const pendingCount = computed(() => {
  return props.bookings.filter((booking) => booking.status === "pending")
    .length;
});

watch(
  currentDate,
  (newDate) => {
    emit("month-changed", {
      month: newDate.getMonth() + 1,
      year: newDate.getFullYear(),
    });
  },
  { deep: true }
);

const dayLabels = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];

const upcomingBookings = computed(() => {
  const year = currentDate.value.getFullYear();
  const month = currentDate.value.getMonth();

  return props.bookings
    .filter((booking) => {
      const bookingDate = new Date(booking.start_at);
      return (
        bookingDate.getFullYear() === year && bookingDate.getMonth() === month
      );
    })
    .sort((a, b) => new Date(a.start_at) - new Date(b.start_at));
});

const allDays = computed(() => {
  const year = currentDate.value.getFullYear();
  const month = currentDate.value.getMonth();

  const firstDay = new Date(year, month, 1);
  const firstDayOfWeek = firstDay.getDay();
  const startDate = new Date(firstDay);
  startDate.setDate(
    startDate.getDate() - (firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1)
  );

  const days = [];
  const currentDayDate = new Date(startDate);

  for (let i = 0; i < 42; i++) {
    days.push({
      date: new Date(currentDayDate),
      dayOfMonth: currentDayDate.getDate(),
      isCurrentMonth:
        currentDayDate.getMonth() === month &&
        currentDayDate.getFullYear() === year,
    });
    currentDayDate.setDate(currentDayDate.getDate() + 1);
  }

  return days;
});

function getBookingsForDay(date) {
  return props.bookings.filter((booking) => {
    const bookingDate = new Date(booking.start_at);
    return (
      bookingDate.getFullYear() === date.getFullYear() &&
      bookingDate.getMonth() === date.getMonth() &&
      bookingDate.getDate() === date.getDate()
    );
  });
}

function previousMonth() {
  const newDate = new Date(currentDate.value);
  newDate.setMonth(newDate.getMonth() - 1);
  currentDate.value = newDate;
}

function nextMonth() {
  const newDate = new Date(currentDate.value);
  newDate.setMonth(newDate.getMonth() + 1);
  currentDate.value = newDate;
}

function selectBooking(booking) {
  selectedBooking.value = booking;
}

function showDayBookings(date) {
  selectedDayDate.value = date;
}

async function handleAcceptBooking(booking) {
  actionInProgress.value = true;
  try {
    await bookingsStore.updateBookingStatus(booking.id, "confirmed");
    alertStore.showAlert("Réservation acceptée", "success");
    selectedBooking.value = null;
    emit("refresh");
  } catch (error) {
    alertStore.showAlert(
      "Erreur lors de l'acceptation de la réservation",
      "error"
    );
  } finally {
    actionInProgress.value = false;
  }
}

async function handleRejectBooking(booking) {
  actionInProgress.value = true;
  try {
    await bookingsStore.updateBookingStatus(booking.id, "cancelled");
    alertStore.showAlert("Réservation refusée", "success");
    selectedBooking.value = null;
    emit("refresh");
  } catch (error) {
    alertStore.showAlert("Erreur lors du refus de la réservation", "error");
  } finally {
    actionInProgress.value = false;
  }
}

function handleBookingUpdated() {
  showPendingModal.value = false;
  emit("refresh");
}
</script>
