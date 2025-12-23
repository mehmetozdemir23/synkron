import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { authAPI, passwordResetAPI, getCsrfCookie } from "../services/api";
import { logError } from "../utils/logger";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const isAuthenticated = computed(() => !!user.value);
  const loading = ref(false);
  const saving = ref(false);
  const error = ref(null);
  const success = ref(null);
  const hasLoaded = ref(false);
  const lastFetch = ref(null);

  const CACHE_DURATION = 5 * 60 * 1000;

  async function register(credentials) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await getCsrfCookie();

      const response = await authAPI.register(credentials);
      user.value = response.data.user;
      success.value = "Inscription réussie !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'inscription";
      logError("AuthStore.register", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function login(credentials) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await getCsrfCookie();

      const response = await authAPI.login(credentials);
      user.value = response.data.user;
      success.value = "Connexion réussie !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la connexion";
      logError("AuthStore.login", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function logout() {
    try {
      loading.value = true;
      await authAPI.logout();
    } catch (error) {
      logError("AuthStore.logout", error);
    } finally {
      user.value = null;
      hasLoaded.value = false;
      lastFetch.value = null;
      loading.value = false;
    }
  }

  async function fetchUser(force = false) {
    if (
      !force &&
      hasLoaded.value &&
      lastFetch.value &&
      Date.now() - lastFetch.value < CACHE_DURATION
    ) {
      return user.value;
    }

    try {
      loading.value = true;
      const response = await authAPI.me();
      user.value = response.data.user;
      hasLoaded.value = true;
      lastFetch.value = Date.now();
      return user.value;
    } catch (error) {
      user.value = null;
      hasLoaded.value = false;
      logError("AuthStore.fetchUser", error);
      throw error;
    } finally {
      loading.value = false;
    }
  }

  async function sendPasswordResetLink(email) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await getCsrfCookie();

      const response = await passwordResetAPI.sendResetLink({ email });
      success.value = "Email de réinitialisation envoyé !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de l'envoi de l'email";
      logError("AuthStore.sendPasswordResetLink", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  async function resetPassword(data) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await getCsrfCookie();

      const response = await passwordResetAPI.resetPassword(data);
      success.value = "Mot de passe réinitialisé avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);

      return response.data;
    } catch (err) {
      error.value =
        err.response?.data?.message ||
        "Erreur lors de la réinitialisation du mot de passe";
      logError("AuthStore.resetPassword", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  function reset() {
    user.value = null;
    loading.value = false;
    saving.value = false;
    error.value = null;
    success.value = null;
    hasLoaded.value = false;
    lastFetch.value = null;
  }

  return {
    user,
    isAuthenticated,
    loading,
    saving,
    error,
    success,
    register,
    login,
    logout,
    fetchUser,
    sendPasswordResetLink,
    resetPassword,
    reset,
  };
});
