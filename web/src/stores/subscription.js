import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { subscriptionAPI } from "../services/api";

export const useSubscriptionStore = defineStore("subscription", () => {
  const usage = ref(null);
  const subscription = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const isPro = computed(() => usage.value?.is_pro ?? false);
  const canBook = computed(() => usage.value?.can_book ?? true);
  const used = computed(() => usage.value?.used ?? 0);
  const limit = computed(() => usage.value?.limit ?? 10);
  const percentage = computed(() => usage.value?.percentage ?? 0);
  const plan = computed(() => usage.value?.plan ?? "free");

  async function fetchStatus() {
    loading.value = true;
    error.value = null;

    try {
      const response = await subscriptionAPI.getStatus();
      usage.value = response.data.usage;
      subscription.value = response.data.subscription;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la récupération du statut";
      console.error("Erreur fetchStatus:", err);
    } finally {
      loading.value = false;
    }
  }

  async function checkout() {
    loading.value = true;
    error.value = null;

    try {
      const response = await subscriptionAPI.checkout();

      if (response.data.url) {
        window.location.href = response.data.url;
      }
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la création de la session de paiement";
      console.error("Erreur checkout:", err);
      loading.value = false;
      throw err;
    }
  }

  async function openBillingPortal() {
    loading.value = true;
    error.value = null;

    try {
      const response = await subscriptionAPI.openPortal();

      if (response.data.url) {
        window.location.href = response.data.url;
      }
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'ouverture du portail";
      console.error("Erreur openBillingPortal:", err);
      loading.value = false;
      throw err;
    }
  }

  async function cancelSubscription() {
    loading.value = true;
    error.value = null;

    try {
      await subscriptionAPI.cancel();
      await fetchStatus();
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'annulation";
      console.error("Erreur cancelSubscription:", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function resumeSubscription() {
    loading.value = true;
    error.value = null;

    try {
      await subscriptionAPI.resume();
      await fetchStatus();
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la réactivation";
      console.error("Erreur resumeSubscription:", err);
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function reset() {
    usage.value = null;
    subscription.value = null;
    loading.value = false;
    error.value = null;
  }

  return {
    usage,
    subscription,
    loading,
    error,

    isPro,
    canBook,
    used,
    limit,
    percentage,
    plan,

    fetchStatus,
    checkout,
    openBillingPortal,
    cancelSubscription,
    resumeSubscription,
    reset,
  };
});
