<template>
  <div class="bg-neutral-200 rounded-xl border border-neutral-400 p-6 sm:p-7">
    <h2 class="text-lg font-medium text-neutral-900 mb-5">Sécurité</h2>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <BaseInput
        v-model="formData.current_password"
        type="password"
        label="Mot de passe actuel"
        placeholder="••••••••"
        required
      />

      <BaseInput
        v-model="formData.new_password"
        type="password"
        label="Nouveau mot de passe"
        placeholder="••••••••"
        required
      />

      <BaseInput
        v-model="formData.new_password_confirmation"
        type="password"
        label="Confirmer le mot de passe"
        placeholder="••••••••"
        required
      />

      <BaseAlert
        v-if="error"
        variant="error"
        :message="error"
        dismissible
        @update:modelValue="error = ''"
      />

      <BaseAlert
        v-if="success"
        variant="success"
        :message="success"
        dismissible
        @update:modelValue="success = ''"
      />

      <div class="pt-2">
        <BaseButton type="submit" variant="primary" :loading="loading">
          {{ loading ? "Changement..." : "Changer le mot de passe" }}
        </BaseButton>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";

const emit = defineEmits(["success"]);

const formData = ref({
  current_password: "",
  new_password: "",
  new_password_confirmation: "",
});

const loading = ref(false);
const error = ref("");
const success = ref("");

async function handleSubmit() {
  error.value = "";
  success.value = "";

  if (
    formData.value.new_password !== formData.value.new_password_confirmation
  ) {
    error.value = "Les nouveaux mots de passe ne correspondent pas";
    return;
  }

  if (formData.value.new_password.length < 8) {
    error.value = "Le mot de passe doit contenir au moins 8 caractères";
    return;
  }

  loading.value = true;

  try {
    const { useAuthStore } = await import("../../stores/auth");
    const authStore = useAuthStore();

    await authStore.changePassword({
      current_password: formData.value.current_password,
      new_password: formData.value.new_password,
      new_password_confirmation: formData.value.new_password_confirmation,
    });

    success.value = "Mot de passe changé avec succès";

    formData.value = {
      current_password: "",
      new_password: "",
      new_password_confirmation: "",
    };

    emit("success");

    setTimeout(() => {
      success.value = "";
    }, 3000);
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      "Erreur lors du changement de mot de passe";
  } finally {
    loading.value = false;
  }
}
</script>
