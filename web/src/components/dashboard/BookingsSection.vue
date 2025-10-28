<template>
  <div>
    <BookingCalendar
      :bookings="bookings"
      :is-loading="isLoading"
      @refresh="onRefresh"
      @month-changed="onMonthChanged"
    />
  </div>
</template>

<script setup>
import { useBookingsStore } from "@/stores/bookings";
import BookingCalendar from "./BookingCalendar.vue";

defineProps({
  bookings: {
    type: Array,
    required: true,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["refresh"]);
const bookingsStore = useBookingsStore();

function onRefresh() {
  emit("refresh");
}

async function onMonthChanged({ month, year }) {
  await bookingsStore.fetchAll({ month, year });
}
</script>
