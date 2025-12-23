import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { bookingsAPI } from "../services/api";
import { logError } from "../utils/logger";

export const useBookingsStore = defineStore("bookings", () => {
  const bookingsByMonth = ref({});
  const currentMonthKey = ref(null);
  const loading = ref(false);
  const saving = ref(false);
  const error = ref(null);
  const success = ref(null);

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
      logError("BookingsStore.fetchAll", new Error("Month and year are required"));
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
      logError("BookingsStore.fetchAll", err);
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
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      const response = await bookingsAPI.confirm(id);
      updateBookingInCache(response.data.booking);
      success.value = "Réservation confirmée avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la confirmation de la réservation";
      logError("BookingsStore.confirm", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function reject(id) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      const response = await bookingsAPI.reject(id);
      updateBookingInCache(response.data.booking);
      success.value = "Réservation rejetée avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors du rejet de la réservation";
      logError("BookingsStore.reject", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function cancel(id) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      const response = await bookingsAPI.cancel(id);
      updateBookingInCache(response.data.booking);
      success.value = "Réservation annulée avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de l'annulation de la réservation";
      logError("BookingsStore.cancel", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  function reset() {
    bookingsByMonth.value = {};
    currentMonthKey.value = null;
    loading.value = false;
    saving.value = false;
    error.value = null;
    success.value = null;
  }

  return {
    bookings,
    loading,
    saving,
    error,
    success,

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
