import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { bookingsAPI } from "../services/api";

export const useBookingsStore = defineStore("bookings", () => {
  const bookingsByMonth = ref({});
  const currentMonthKey = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const bookings = computed(() => {
    if (!currentMonthKey.value) return [];
    return bookingsByMonth.value[currentMonthKey.value] || [];
  });

  const confirmedBookings = computed(() =>
    bookings.value.filter((b) => b.status === "confirmed")
  );
  const pendingBookings = computed(() =>
    bookings.value.filter((b) => b.status === "pending")
  );
  const cancelledBookings = computed(() =>
    bookings.value.filter((b) => b.status === "cancelled")
  );
  const hasBookings = computed(() => bookings.value.length > 0);

  function getMonthKey(month, year) {
    return `${year}-${month}`;
  }

  async function fetchAll(params = {}, options = { force: false }) {
    const { month, year } = params;
    if (!month || !year) {
      console.error("Month and year are required");
      return;
    }

    const monthKey = getMonthKey(month, year);
    currentMonthKey.value = monthKey;

    if (!options.force && bookingsByMonth.value[monthKey]) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await bookingsAPI.getAll(params);
      bookingsByMonth.value[monthKey] = response.data.bookings;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors du chargement des réservations";
      console.error("Error fetching bookings:", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function fetchById(id) {
    loading.value = true;
    error.value = null;

    try {
      const response = await bookingsAPI.get(id);
      return response.data.booking;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors du chargement de la réservation";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function updateBookingInCache(updatedBooking) {
    Object.keys(bookingsByMonth.value).forEach((monthKey) => {
      const index = bookingsByMonth.value[monthKey].findIndex(
        (b) => b.id === updatedBooking.id
      );
      if (index !== -1) {
        bookingsByMonth.value[monthKey][index] = updatedBooking;
      }
    });
  }

  async function confirm(id) {
    loading.value = true;
    error.value = null;

    try {
      const response = await bookingsAPI.confirm(id);
      updateBookingInCache(response.data.booking);
      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la confirmation de la réservation";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function reject(id) {
    loading.value = true;
    error.value = null;

    try {
      const response = await bookingsAPI.reject(id);
      updateBookingInCache(response.data.booking);
      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors du rejet de la réservation";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function cancel(id) {
    loading.value = true;
    error.value = null;

    try {
      const response = await bookingsAPI.cancel(id);
      updateBookingInCache(response.data.booking);
      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de l'annulation de la réservation";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function reset() {
    bookingsByMonth.value = {};
    currentMonthKey.value = null;
    loading.value = false;
    error.value = null;
  }

  return {
    bookings,
    loading,
    error,

    confirmedBookings,
    pendingBookings,
    cancelledBookings,
    hasBookings,

    fetchAll,
    fetchById,
    confirm,
    reject,
    cancel,
    reset,
  };
});
