import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { availabilitiesAPI } from "../services/api";
import { logError } from "../utils/logger";

export const useAvailabilitiesStore = defineStore("availabilities", () => {
  const availabilities = ref([]);
  const loading = ref(false);
  const saving = ref(false);
  const error = ref(null);
  const success = ref(null);
  const lastFetch = ref(null);

  const days = ref([
    { value: 0, label: "Dimanche", slots: [] },
    { value: 1, label: "Lundi", slots: [] },
    { value: 2, label: "Mardi", slots: [] },
    { value: 3, label: "Mercredi", slots: [] },
    { value: 4, label: "Jeudi", slots: [] },
    { value: 5, label: "Vendredi", slots: [] },
    { value: 6, label: "Samedi", slots: [] },
  ]);

  const hasAvailabilities = computed(() => availabilities.value.length > 0);

  const groupedByDay = computed(() => days.value);

  async function fetchAll(options = { force: false }) {
    const isFresh = lastFetch.value && Date.now() - lastFetch.value < 60000;
    if (!options.force && isFresh && availabilities.value.length > 0) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await availabilitiesAPI.getAll();
      availabilities.value = response.data.availabilities;
      lastFetch.value = Date.now();

      days.value.forEach((day) => {
        day.slots = [];
      });

      availabilities.value.forEach((avail) => {
        const day = days.value.find((d) => d.value === avail.day_of_week);
        if (day) {
          day.slots.push({
            start_time: avail.start_time.substring(0, 5),
            end_time: avail.end_time.substring(0, 5),
          });
        }
      });
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors du chargement des disponibilités";
      logError("AvailabilitiesStore.fetchAll", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function upsert(data) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await availabilitiesAPI.upsert(data);
      await fetchAll({ force: true });
      success.value = "Disponibilités enregistrées avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'enregistrement";
      logError("AvailabilitiesStore.upsert", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  function reset() {
    availabilities.value = [];
    loading.value = false;
    saving.value = false;
    error.value = null;
    success.value = null;
    lastFetch.value = null;
  }

  return {
    availabilities,
    loading,
    saving,
    error,
    success,

    hasAvailabilities,
    groupedByDay,

    fetchAll,
    upsert,
    reset,
  };
});
