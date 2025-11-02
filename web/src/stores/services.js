import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { servicesAPI } from "../services/api";

export const useServicesStore = defineStore("services", () => {
  const services = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const lastFetch = ref(null);

  const activeServices = computed(() =>
    services.value.filter((s) => s.is_active)
  );
  const inactiveServices = computed(() =>
    services.value.filter((s) => !s.is_active)
  );
  const hasServices = computed(() => services.value.length > 0);

  async function fetchAll(options = { force: false }) {
    const isFresh = lastFetch.value && Date.now() - lastFetch.value < 60000;
    if (!options.force && isFresh && services.value.length > 0) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await servicesAPI.getAll();
      services.value = response.data.services;
      lastFetch.value = Date.now();
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors du chargement des services";
      console.error("Error fetching services:", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function create(data) {
    loading.value = true;
    error.value = null;

    try {
      const response = await servicesAPI.create(data);
      services.value.push(response.data.service);
      return response.data.service;
    } catch (err) {
      error.value = err.response?.data?.message || "Erreur lors de la création";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function update(id, data) {
    loading.value = true;
    error.value = null;

    try {
      const response = await servicesAPI.update(id, data);
      const index = services.value.findIndex((s) => s.id === id);
      if (index !== -1) {
        services.value[index] = response.data.service;
      }
      return response.data.service;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la mise à jour";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function remove(id) {
    loading.value = true;
    error.value = null;

    try {
      await servicesAPI.delete(id);
      services.value = services.value.filter((s) => s.id !== id);
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la suppression";
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function reset() {
    services.value = [];
    loading.value = false;
    error.value = null;
    lastFetch.value = null;
  }

  return {
    services,
    loading,
    error,

    activeServices,
    inactiveServices,
    hasServices,

    fetchAll,
    create,
    update,
    remove,
    reset,
  };
});
