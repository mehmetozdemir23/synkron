<template>
  <div class="space-y-4">
    <div
      class="bg-neutral-200 rounded-xl border border-neutral-400 overflow-hidden"
    >
      <div
        class="p-4 border-b border-neutral-400"
        v-memo="[pendingCount, currentDate]"
      >
        <div class="lg:hidden">
          <div class="flex items-center justify-between mb-2">
            <button
              @click="previousMonth"
              class="p-1.5 hover:bg-neutral-300 active:bg-neutral-400 rounded-full transition-colors"
            >
              <ChevronLeft class="w-5 h-5 text-neutral-800" />
            </button>

            <h3 class="capitalize text-lg font-medium text-neutral-900">
              {{ formatMonthYear(currentDate) }}
            </h3>

            <button
              @click="nextMonth"
              class="p-1.5 hover:bg-neutral-300 active:bg-neutral-400 rounded-full transition-colors"
            >
              <ChevronRight class="w-5 h-5 text-neutral-800" />
            </button>
          </div>

          <div v-if="pendingCount > 0" class="flex justify-center">
            <button
              @click="showPendingModal = true"
              class="px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200 active:bg-amber-300 transition-colors flex items-center gap-1.5"
            >
              <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
              <span>{{ pendingCount }} en attente</span>
              <ArrowRight class="w-3.5 h-3.5 text-amber-700" />
            </button>
          </div>
        </div>

        <div class="hidden lg:flex items-center justify-between">
          <div class="flex items-center gap-3">
            <h3 class="capitalize text-lg font-medium text-neutral-900">
              {{ formatMonthYear(currentDate) }}
            </h3>
            <button
              v-if="pendingCount > 0"
              @click="showPendingModal = true"
              class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200 active:bg-amber-300 transition-colors flex items-center gap-1.5"
            >
              <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
              <span
                >{{ pendingCount }} réservation{{
                  pendingCount > 1 ? "s" : ""
                }}
                en attente</span
              >
              <ArrowRight class="h-4 w-4 text-amber-700" />
            </button>
          </div>

          <div class="flex items-center gap-1">
            <button
              @click="previousMonth"
              class="p-2 hover:bg-neutral-300 active:bg-neutral-400 rounded-full transition-colors"
            >
              <ChevronLeft class="w-5 h-5 text-neutral-800" />
            </button>
            <button
              @click="nextMonth"
              class="p-2 hover:bg-neutral-300 active:bg-neutral-400 rounded-full transition-colors"
            >
              <ChevronRight class="w-5 h-5 text-neutral-800" />
            </button>
          </div>
        </div>
      </div>

      <div class="lg:hidden">
        <div
          v-if="upcomingBookings.length === 0"
          class="text-center py-12 text-neutral-700"
        >
          <p class="text-sm font-medium">Aucune réservation ce mois</p>
        </div>
        <div
          v-else
          class="h-[calc(100vh-280px)] min-h-[300px] max-h-[500px] overflow-y-auto p-4 space-y-2"
        >
          <div
            v-for="booking in upcomingBookings"
            :key="booking.id"
            @click="selectBooking(booking)"
            class="p-3 rounded-xl bg-neutral-100 cursor-pointer transition-colors hover:bg-neutral-300 active:bg-neutral-400"
          >
            <div class="flex items-start justify-between gap-3">
              <div class="flex-1 min-w-0">
                <p class="font-medium text-sm text-neutral-900">
                  {{ booking.service.name }}
                </p>
                <p class="text-xs text-neutral-700 mt-1">
                  {{ formatDateShort(booking.start_at) }} •
                  {{ formatTime(booking.start_at) }}
                </p>
              </div>
              <span
                :class="[
                  'px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0',
                  getStatusBadgeClass(booking.status),
                ]"
              >
                {{ getStatusLabel(booking.status) }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="hidden lg:block">
        <div
          class="grid grid-cols-7 gap-px bg-neutral-400 border-b border-neutral-400"
          v-memo="[]"
        >
          <div
            v-for="day in dayLabels"
            :key="day"
            class="p-2 text-center font-medium text-xs text-neutral-700 uppercase tracking-wide bg-neutral-100"
          >
            {{ day }}
          </div>
        </div>

        <div v-if="isLoading" class="grid grid-cols-7 gap-px bg-neutral-400">
          <div v-for="i in 35" :key="i" class="min-h-24 p-2 bg-neutral-200">
            <div
              class="h-4 bg-neutral-300 rounded w-6 mb-2 animate-pulse"
            ></div>
            <div class="space-y-1">
              <div class="h-6 bg-neutral-300 rounded animate-pulse"></div>
            </div>
          </div>
        </div>

        <div v-else class="grid grid-cols-7 gap-px bg-neutral-400">
          <div
            v-for="(day, _) in allDays"
            :key="`${day.date.getFullYear()}-${day.date.getMonth()}-${
              day.dayOfMonth
            }`"
            :class="[
              'h-32 p-2 relative',
              day.isCurrentMonth
                ? 'bg-neutral-200 hover:bg-neutral-300'
                : 'bg-neutral-100/50',
            ]"
          >
            <div
              :class="[
                'text-sm font-medium mb-1.5',
                day.isCurrentMonth ? 'text-neutral-900' : 'text-neutral-600',
              ]"
            >
              {{ day.dayOfMonth }}
            </div>

            <div class="space-y-1 overflow-hidden">
              <div
                v-for="booking in getBookingsForDay(day.date).slice(0, 2)"
                :key="booking.id"
                @click="selectBooking(booking)"
                :class="[
                  'text-xs px-2 py-1 rounded-full cursor-pointer truncate font-medium',
                  booking.status === 'pending'
                    ? 'bg-amber-200 text-amber-900 hover:bg-amber-300'
                    : 'bg-brand-200 text-brand-900 hover:bg-brand-300',
                ]"
              >
                {{ formatTime(booking.start_at) }} {{ booking.service.name }}
              </div>
              <button
                v-if="getBookingsForDay(day.date).length > 2"
                @click="showDayBookings(day.date)"
                class="text-xs text-brand-700 px-2 font-medium hover:text-brand-900 hover:underline cursor-pointer w-full text-left"
              >
                +{{ getBookingsForDay(day.date).length - 2 }} autre{{
                  getBookingsForDay(day.date).length - 2 > 1 ? "s" : ""
                }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <BaseModal :show="!!selectedBooking" @close="selectedBooking = null">
      <template #header> Détails de la réservation </template>

      <div v-if="selectedBooking" class="space-y-6">
        <div class="flex items-start justify-between gap-4">
          <div class="flex-1">
            <p
              class="text-xs text-neutral-500 font-semibold tracking-wider uppercase"
            >
              Service
            </p>
            <p class="text-2xl font-semibold text-neutral-900 mt-2">
              {{ selectedBooking.service.name }}
            </p>
          </div>

          <div
            :class="[
              'px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2.5 whitespace-nowrap',
              getStatusBadgeClass(selectedBooking.status),
            ]"
          >
            <div
              :class="[
                'w-2.5 h-2.5 rounded-full',
                getStatusColor(selectedBooking.status),
              ]"
            ></div>
            {{ getStatusLabel(selectedBooking.status) }}
          </div>
        </div>

        <div
          class="h-px bg-gradient-to-r from-neutral-100 to-transparent"
        ></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
          <div class="space-y-2">
            <p
              class="text-xs text-neutral-600 font-semibold tracking-wider uppercase"
            >
              Date
            </p>
            <p class="text-lg font-semibold text-neutral-900">
              {{ formatDateShort(selectedBooking.start_at) }}
            </p>
            <p class="text-xs text-neutral-600">
              {{ formatDateFull(selectedBooking.start_at) }}
            </p>
          </div>
          <div class="space-y-2">
            <p
              class="text-xs text-neutral-600 font-semibold tracking-wider uppercase"
            >
              Heure
            </p>
            <p class="text-lg font-semibold text-neutral-900">
              {{ formatTime(selectedBooking.start_at) }}
            </p>
            <p class="text-xs text-neutral-600">
              {{ selectedBooking.service.duration_minutes }} min • heure locale
            </p>
          </div>
        </div>

        <div class="space-y-5">
          <div class="space-y-2">
            <p
              class="text-xs text-neutral-600 font-semibold tracking-wider uppercase"
            >
              Client
            </p>
            <p class="text-base text-neutral-900 font-semibold">
              {{ selectedBooking.client_name }}
            </p>
          </div>

          <div class="space-y-2">
            <p
              class="text-xs text-neutral-600 font-semibold tracking-wider uppercase"
            >
              Email
            </p>
            <p class="text-base text-neutral-900 font-semibold break-all">
              {{ selectedBooking.client_email }}
            </p>
          </div>
        </div>

        <div
          v-if="selectedBooking.service.description"
          class="bg-neutral-100 rounded-lg p-4 border border-neutral-400"
        >
          <p
            class="text-xs text-neutral-700 font-semibold tracking-wider uppercase mb-2"
          >
            Description
          </p>
          <p class="text-sm text-neutral-800 leading-relaxed">
            {{ selectedBooking.service.description }}
          </p>
        </div>
      </div>

      <template #footer>
        <div class="flex gap-3">
          <button
            v-if="selectedBooking?.status === 'pending'"
            @click="rejectBooking(selectedBooking.id)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-50 active:bg-error-100 rounded-lg transition-colors disabled:opacity-40"
          >
            <X class="w-4 h-4" />
            {{ actionInProgress ? "Rejet..." : "Rejeter" }}
          </button>
          <button
            v-if="selectedBooking?.status === 'pending'"
            @click="confirmBooking(selectedBooking.id)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 hover:shadow-sm active:bg-brand-700 rounded-lg transition-all disabled:opacity-40"
          >
            <Check class="w-4 h-4" />
            {{ actionInProgress ? "Confirmation..." : "Confirmer" }}
          </button>

          <button
            v-if="
              selectedBooking?.status === 'confirmed' &&
              !isPast(selectedBooking.start_at)
            "
            @click="cancelBooking(selectedBooking.id)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-50 active:bg-error-100 rounded-lg transition-colors disabled:opacity-40"
          >
            <X class="w-4 h-4" />
            {{ actionInProgress ? "Annulation..." : "Annuler" }}
          </button>
        </div>
      </template>
    </BaseModal>

    <BaseModal
      :show="showPendingModal"
      @close="showPendingModal = false"
      size="lg"
    >
      <template #header> Réservations en attente </template>

      <PendingBookings :bookings="bookings" @refresh="onPendingRefresh" />
    </BaseModal>

    <BaseModal
      :show="!!selectedDayDate"
      @close="selectedDayDate = null"
      size="lg"
    >
      <template #header>
        Réservations du
        {{
          selectedDayDate ? formatDateFull(selectedDayDate.toISOString()) : ""
        }}
      </template>

      <div
        v-if="selectedDayDate"
        class="space-y-3 overflow-y-auto max-h-[50vh] sm:max-h-[60vh]"
      >
        <div
          v-for="booking in getBookingsForDay(selectedDayDate)"
          :key="booking.id"
          @click="
            selectBooking(booking);
            selectedDayDate = null;
          "
          class="p-4 rounded-xl bg-neutral-100 border border-neutral-300 cursor-pointer hover:bg-neutral-300"
        >
          <div class="flex items-start justify-between gap-3 mb-2">
            <div class="flex-1">
              <p class="font-medium text-neutral-900">
                {{ booking.service.name }}
              </p>
              <p class="text-sm text-neutral-700 mt-1">
                {{ formatTime(booking.start_at) }}
              </p>
            </div>
            <span
              :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                getStatusBadgeClass(booking.status),
              ]"
            >
              {{ getStatusLabel(booking.status) }}
            </span>
          </div>

          <p class="text-sm text-neutral-800">{{ booking.client_name }}</p>
        </div>

        <p
          v-if="getBookingsForDay(selectedDayDate).length === 0"
          class="text-center text-neutral-600 py-8"
        >
          Aucune réservation pour cette journée
        </p>
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

const { formatTime, formatDateShort, formatDateFull, formatMonthYear } =
  useFormatters();
const { getStatusBadgeClass, getStatusLabel, getStatusColor } =
  useStatusClasses();

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

function isPast(dateString) {
  return new Date(dateString) < new Date();
}

async function confirmBooking(bookingId) {
  actionInProgress.value = true;
  try {
    await bookingsStore.confirm(bookingId);
    selectedBooking.value = null;
    emit("refresh");
  } catch (error) {
    await alertStore.error(
      error.message || "Une erreur est survenue lors de la confirmation"
    );
  } finally {
    actionInProgress.value = false;
  }
}

async function rejectBooking(bookingId) {
  if (!confirm("Êtes-vous sûr de vouloir rejeter cette réservation ?")) {
    return;
  }

  actionInProgress.value = true;
  try {
    await bookingsStore.reject(bookingId);
    selectedBooking.value = null;
    emit("refresh");
  } catch (error) {
    await alertStore.error(
      error.message || "Une erreur est survenue lors du rejet"
    );
  } finally {
    actionInProgress.value = false;
  }
}

async function cancelBooking(bookingId) {
  if (!confirm("Êtes-vous sûr de vouloir annuler cette réservation ?")) {
    return;
  }

  actionInProgress.value = true;
  try {
    await bookingsStore.cancel(bookingId);
    selectedBooking.value = null;
    emit("refresh");
  } catch (error) {
    await alertStore.error(
      error.message || "Une erreur est survenue lors de l'annulation"
    );
  } finally {
    actionInProgress.value = false;
  }
}

async function onPendingRefresh() {
  emit("refresh");
  showPendingModal.value = false;
}
</script>
