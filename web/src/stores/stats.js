import { defineStore } from "pinia";
import { ref } from "vue";
import { statsAPI } from "../services/api";

export const useStatsStore = defineStore("stats", () => {
  const stats = ref({
    services: 0,
    availabilities: 0,
    bookings: 0,
    upcoming_confirmed_bookings: 0,
    upcoming_pending_bookings: 0,
    confirmed_this_month: 0,
    revenue_this_month: 0,
  });

  const loading = ref(false);
  const error = ref(null);
  const hasLoaded = ref(false);

  async function fetch(force = false) {
    if (!force && hasLoaded.value) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await statsAPI.get();
      stats.value = response.data.stats;
      hasLoaded.value = true;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors du chargement des stats";
      console.error("Error fetching stats:", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function reset() {
    stats.value = {
      services: 0,
      availabilities: 0,
      bookings: 0,
      upcoming_confirmed_bookings: 0,
      upcoming_pending_bookings: 0,
      confirmed_this_month: 0,
      revenue_this_month: 0,
    };
    loading.value = false;
    error.value = null;
    hasLoaded.value = false;
  }

  return {
    stats,
    loading,
    error,
    hasLoaded,

    fetch,
    reset,
  };
});
