<template>
  <div v-if="pendingBookings.length > 0">
    
    <div class="mb-4">
      <div
        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 rounded-full border border-amber-300"
      >
        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
        <span class="text-sm font-medium text-amber-900">
          {{ pendingBookings.length }}
          {{ pendingBookings.length > 1 ? "réservations" : "réservation" }} à
          traiter
        </span>
      </div>
    </div>

    
    <div class="space-y-3 overflow-y-auto max-h-[60vh]">
      <div
        v-for="booking in pendingBookings"
        :key="booking.id"
        class="bg-neutral-200 rounded-2xl border border-neutral-400 overflow-hidden"
      >
        <div class="p-4">
          <h3 class="text-base font-medium text-neutral-900 mb-3">
            {{ booking.service.name }}
          </h3>

          <div class="space-y-2 mb-4">
            <div class="flex items-center gap-3 text-sm text-neutral-800">
              <Calendar class="w-5 h-5 text-neutral-600" />
              {{ formatDateShort(booking.start_at) }}
            </div>
            <div class="flex items-center gap-3 text-sm text-neutral-800">
              <Clock class="w-5 h-5 text-neutral-600" />
              {{ formatTime(booking.start_at) }}
            </div>
            <div class="flex items-center gap-3 text-sm text-neutral-800">
              <User class="w-5 h-5 text-neutral-600" />
              {{ booking.client_name }}
            </div>
          </div>
        </div>

        <div class="flex gap-3 p-4 border-t border-neutral-300">
          <button
            @click="rejectBooking(booking.id)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-50 active:bg-error-100 rounded-lg transition-colors disabled:opacity-40"
          >
            <X class="w-4 h-4" />
            <span>Rejeter</span>
          </button>
          <button
            @click="confirmBooking(booking.id)"
            :disabled="actionInProgress"
            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 hover:shadow-sm active:bg-brand-700 rounded-lg transition-all disabled:opacity-40"
          >
            <Check class="w-4 h-4" />
            <span>Confirmer</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  
  <div v-else class="flex flex-col items-center justify-center p-12 text-center">
    <div class="w-12 h-12 rounded-full bg-neutral-300 flex items-center justify-center mb-3">
      <Check class="w-6 h-6 text-neutral-600" />
    </div>
    <p class="text-sm font-medium text-neutral-900 mb-1">Tout est à jour</p>
    <p class="text-sm text-neutral-700">Aucune réservation en attente</p>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { X, Check, Calendar, Clock, User } from "lucide-vue-next";
import { useBookingsStore } from "@/stores/bookings";
import { useFormatters } from "@/composables/useFormatters";

const { formatTime, formatDateShort } = useFormatters();

const bookingsStore = useBookingsStore();
const actionInProgress = ref(false);

const props = defineProps({
  bookings: Array,
});

const emit = defineEmits(["refresh"]);

const pendingBookings = computed(() =>
  props.bookings
    .filter((b) => b.status === "pending")
    .sort((a, b) => new Date(a.start_at) - new Date(b.start_at))
);

async function confirmBooking(id) {
  actionInProgress.value = true;
  try {
    await bookingsStore.confirm(id);
    emit("refresh");
  } finally {
    actionInProgress.value = false;
  }
}

async function rejectBooking(id) {
  if (!confirm("Êtes-vous sûr ?")) return;
  actionInProgress.value = true;
  try {
    await bookingsStore.reject(id);
    emit("refresh");
  } finally {
    actionInProgress.value = false;
  }
}
</script>
