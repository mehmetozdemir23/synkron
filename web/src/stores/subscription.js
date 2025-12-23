import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { subscriptionAPI } from "../services/api";
import { safeRedirect } from "../utils/security";
import { logError } from "../utils/logger";

export const useSubscriptionStore = defineStore("subscription", () => {
  const usage = ref(null);
  const subscription = ref(null);
  const loading = ref(false);
  const saving = ref(false);
  const error = ref(null);
  const success = ref(null);
  const hasLoaded = ref(false);
  const lastFetch = ref(null);

  const CACHE_DURATION = 5 * 60 * 1000;

  const isPro = computed(() => usage.value?.is_pro ?? false);
  const canBook = computed(() => usage.value?.can_book ?? true);
  const used = computed(() => usage.value?.used ?? 0);
  const limit = computed(() => usage.value?.limit ?? 10);
  const percentage = computed(() => usage.value?.percentage ?? 0);
  const plan = computed(() => usage.value?.plan ?? "free");

  async function fetchStatus(force = false) {
    if (
      !force &&
      hasLoaded.value &&
      lastFetch.value &&
      Date.now() - lastFetch.value < CACHE_DURATION
    ) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await subscriptionAPI.getStatus();
      usage.value = response.data.usage;
      subscription.value = response.data.subscription;
      hasLoaded.value = true;
      lastFetch.value = Date.now();
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la récupération du statut";
      logError("SubscriptionStore.fetchStatus", err);
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
        safeRedirect(response.data.url, {
          allowedDomains: ["checkout.stripe.com"],
          fallbackUrl: "/dashboard/profile",
        });
      }
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la création de la session de paiement";
      logError("SubscriptionStore.checkout", err);
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
        safeRedirect(response.data.url, {
          allowedDomains: ["billing.stripe.com"],
          fallbackUrl: "/dashboard/profile",
        });
      }
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'ouverture du portail";
      logError("SubscriptionStore.openBillingPortal", err);
      loading.value = false;
      throw err;
    }
  }

  async function cancelSubscription() {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await subscriptionAPI.cancel();
      await fetchStatus();
      success.value = "Abonnement annulé avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'annulation";
      logError("SubscriptionStore.cancelSubscription", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function resumeSubscription() {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await subscriptionAPI.resume();
      await fetchStatus();
      success.value = "Abonnement réactivé avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la réactivation";
      logError("SubscriptionStore.resumeSubscription", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  function reset() {
    usage.value = null;
    subscription.value = null;
    loading.value = false;
    saving.value = false;
    error.value = null;
    success.value = null;
    hasLoaded.value = false;
    lastFetch.value = null;
  }

  return {
    usage,
    subscription,
    loading,
    saving,
    error,
    success,

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
