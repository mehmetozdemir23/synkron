<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
      <div class="w-full max-w-md">
        <div class="mb-6 sm:mb-8">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-2">
            Mot de passe oublié
          </h1>
          <p class="text-base text-neutral-600">
            Entrez votre email pour recevoir un lien de réinitialisation.
          </p>
        </div>

        <BaseAlert
          v-if="success"
          variant="success"
          :message="successMessage"
          :model-value="success"
          class="mb-6"
        >
          <p v-if="resetUrl" class="text-xs text-success-600 mt-3 break-all">
            Lien:
            <a
              :href="resetUrl"
              class="underline hover:text-success-800 transition-colors"
              >{{ resetUrl }}</a
            >
          </p>
        </BaseAlert>

        <div
          class="bg-neutral-100 rounded-2xl shadow-md hover:shadow-lg transition-all p-6 sm:p-8 animate-fade-in"
        >
          <AuthForm :loading="loading" :error="error" @submit="handleSubmit">
            <BaseInput
              v-model="formData.email"
              type="email"
              label="Adresse email"
              placeholder="vous@exemple.com"
              :error="fieldErrors.email"
              :disabled="loading"
              required
            />

            <template #submit-label>Envoyer le lien</template>
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

    <AppFooter />
  </div>
</template>

<script setup>
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AuthForm from "@/components/forms/AuthForm.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import { useAuthStore } from "@/stores/auth";
import { useFormValidation } from "@/composables/useFormValidation";
import { ref, computed } from "vue";
import { ArrowLeft } from "lucide-vue-next";

const authStore = useAuthStore();

const { formData, fieldErrors, setFieldErrors } = useFormValidation({
  email: "",
});

const loading = computed(() => authStore.saving);
const error = computed(() => authStore.error);
const success = computed(() => !!authStore.success);
const successMessage = computed(() => authStore.success || "");
const resetUrl = ref(null);

const handleSubmit = async () => {
  setFieldErrors({});
  resetUrl.value = null;

  try {
    const response = await authStore.sendPasswordResetLink(
      formData.value.email
    );

    if (response.reset_url) {
      resetUrl.value = response.reset_url;
    }

    formData.value.email = "";
  } catch (err) {
    if (err.response?.data?.errors) {
      setFieldErrors(err.response.data.errors);
    }
  }
};
</script>
