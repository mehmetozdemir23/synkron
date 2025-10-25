<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
      <div class="w-full max-w-md">
        <div v-if="!success">
          <div class="mb-6 sm:mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-2">
              Nouveau mot de passe
            </h1>
            <p class="text-base text-neutral-600">
              Choisissez un mot de passe sécurisé pour votre compte.
            </p>
          </div>

          <BaseAlert
            v-if="invalidLink"
            variant="error"
            :message="error"
            :model-value="invalidLink"
            class="mb-6"
          />

          <div
            class="bg-neutral-200 rounded-2xl border border-neutral-400 shadow-md hover:shadow-lg transition-all p-6 sm:p-8 animate-fade-in"
          >
            <AuthForm :loading="loading" :error="error" @submit="handleSubmit">
              <BaseInput
                v-model="formData.password"
                type="password"
                label="Nouveau mot de passe"
                placeholder="Minimum 8 caractères"
                :icon-component="Lock"
                :error="fieldErrors.password"
                :disabled="loading || invalidLink"
                required
                minlength="8"
              />

              <BaseInput
                v-model="formData.password_confirmation"
                type="password"
                label="Confirmer le mot de passe"
                placeholder="Confirmez votre mot de passe"
                :icon-component="Lock"
                :disabled="loading || invalidLink"
                required
                minlength="8"
              />

              <template #submit-label>Réinitialiser le mot de passe</template>
            </AuthForm>
          </div>

          <div class="mt-6 text-center">
            <router-link
              to="/login"
              class="text-sm text-brand-600 hover:text-brand-700 font-medium transition-colors inline-flex items-center gap-1"
            >
              <ArrowLeft class="w-4 h-4" />
              Retour à la connexion
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import AuthForm from "@/components/forms/AuthForm.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import { useAuthStore } from "@/stores/auth";
import { useFormValidation } from "@/composables/useFormValidation";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { ArrowLeft, ArrowRight, Lock } from "lucide-vue-next";

const route = useRoute();
const authStore = useAuthStore();

const {
  formData,
  fieldErrors,
  error,
  loading,
  setFieldErrors,
  setError,
  setLoading,
} = useFormValidation({
  email: "",
  token: "",
  password: "",
  password_confirmation: "",
});

const success = ref(false);
const successMessage = ref("");
const invalidLink = ref(false);

onMounted(() => {
  formData.value.token = route.query.token || "";
  formData.value.email = route.query.email || "";

  if (!formData.value.token || !formData.value.email) {
    invalidLink.value = true;
    setError(
      "Lien de réinitialisation invalide. Veuillez demander un nouveau lien."
    );
  }
});

const handleSubmit = async () => {
  setFieldErrors({});
  setError("");

  if (formData.value.password !== formData.value.password_confirmation) {
    setFieldErrors({ password: "Les mots de passe ne correspondent pas" });
    return;
  }

  setLoading(true);

  try {
    const response = await authStore.resetPassword(formData.value);

    success.value = true;
    successMessage.value = response.message;
  } catch (err) {
    if (err.response?.data?.errors) {
      setFieldErrors(err.response.data.errors);
    } else {
      setError(err.response?.data?.message || "Une erreur est survenue");
    }
  } finally {
    setLoading(false);
  }
};
</script>
