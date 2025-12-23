import { defineStore } from "pinia";
import { ref } from "vue";
import { profileAPI } from "../services/api";
import { logError } from "../utils/logger";

export const useProfileStore = defineStore("profile", () => {
  const loading = ref(false);
  const saving = ref(false);
  const error = ref(null);
  const success = ref(null);

  async function update(data) {
    saving.value = true;
    error.value = null;
    success.value = null;

    try {
      await profileAPI.update(data);
      success.value = "Profil mis à jour avec succès !";

      setTimeout(() => {
        success.value = null;
      }, 3000);
    } catch (err) {
      error.value =
        err.response?.data?.message || "Erreur lors de la mise à jour";
      logError("ProfileStore.update", err);
      throw err;
    } finally {
      saving.value = false;
    }
  }

  function reset() {
    loading.value = false;
    saving.value = false;
    error.value = null;
    success.value = null;
  }

  return {
    loading,
    saving,
    error,
    success,

    update,
    reset,
  };
});
