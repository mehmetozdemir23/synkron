import { defineStore } from "pinia";
import { ref, computed } from "vue";
import { authAPI, passwordResetAPI, getCsrfCookie } from "../services/api";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const isAuthenticated = computed(() => !!user.value);
  const isLoading = ref(false);

  async function register(credentials) {
    try {
      isLoading.value = true;

      await getCsrfCookie();

      const response = await authAPI.register(credentials);
      user.value = response.data.user;
      return response.data;
    } catch (error) {
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  async function login(credentials) {
    try {
      isLoading.value = true;

      await getCsrfCookie();

      const response = await authAPI.login(credentials);
      user.value = response.data.user;
      return response.data;
    } catch (error) {
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  async function logout() {
    try {
      isLoading.value = true;
      await authAPI.logout();
    } catch (error) {
      console.error("Logout error:", error);
    } finally {
      user.value = null;
      isLoading.value = false;
    }
  }

  async function fetchUser() {
    try {
      isLoading.value = true;
      const response = await authAPI.me();
      user.value = response.data.user;
      return user.value;
    } catch (error) {
      user.value = null;
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  async function sendPasswordResetLink(email) {
    try {
      isLoading.value = true;

      await getCsrfCookie();

      const response = await passwordResetAPI.sendResetLink({ email });
      return response.data;
    } catch (error) {
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  async function resetPassword(data) {
    try {
      isLoading.value = true;

      await getCsrfCookie();

      const response = await passwordResetAPI.resetPassword(data);
      return response.data;
    } catch (error) {
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  return {
    user,
    isAuthenticated,
    isLoading,
    register,
    login,
    logout,
    fetchUser,
    sendPasswordResetLink,
    resetPassword,
  };
});
