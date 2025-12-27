<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
      <div class="w-full max-w-md">
        <div class="mb-6 sm:mb-8">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-2">
            Créer un compte
          </h1>
          <p class="text-base text-neutral-600">
            Rejoignez nos réservations gratuites. Aucune carte requise.
          </p>
        </div>

        <div class="transition-all animate-fade-in">
          <div class="space-y-5">
            <AuthForm
              :error="error"
              :loading="loading"
              @submit="handleRegister"
            >
              <BaseInput
                v-model="formData.firstname"
                type="text"
                label="Prénom"
                placeholder="Jean"
                :icon-component="User"
                :error="fieldErrors.firstname"
                required
              />

              <BaseInput
                v-model="formData.lastname"
                type="text"
                label="Nom"
                placeholder="Dupont"
                :icon-component="User"
                :error="fieldErrors.lastname"
                required
              />

              <BaseInput
                v-model="formData.email"
                type="email"
                label="Adresse email"
                placeholder="vous@exemple.com"
                :icon-component="Mail"
                :error="fieldErrors.email"
                required
              />

              <BaseInput
                v-model="formData.password"
                type="password"
                label="Mot de passe"
                placeholder="Minimum 8 caractères"
                :icon-component="Lock"
                :error="fieldErrors.password"
                required
              />

              <BaseInput
                v-model="formData.password_confirmation"
                type="password"
                label="Confirmer le mot de passe"
                placeholder="Confirmez votre mot de passe"
                :icon-component="Lock"
                :error="fieldErrors.password_confirmation"
                required
              />

              <template #submit-label>Créer un compte</template>
            </AuthForm>
          </div>

          <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-neutral-300"></div>
            </div>
            <div class="relative flex justify-center">
              <span class="px-3 bg-white text-sm text-neutral-600 font-medium"
                >ou</span
              >
            </div>
          </div>

          <div>
            <GoogleOAuthButton />
          </div>
        </div>

        <div class="text-center space-y-4 mt-6">
          <p class="text-xs text-neutral-600">
            En vous inscrivant, vous acceptez nos
            <router-link
              to="/terms"
              class="text-brand-600 hover:text-brand-700 font-medium transition-colors"
              >conditions d'utilisation</router-link
            >
            et notre
            <router-link
              to="/privacy"
              class="text-brand-600 hover:text-brand-700 font-medium transition-colors"
              >politique de confidentialité</router-link
            >.
          </p>

          <p class="text-sm text-neutral-600">
            Vous avez déjà un compte ?
            <router-link
              to="/login"
              class="text-brand-600 hover:text-brand-700 font-semibold transition-colors"
            >
              Se connecter
            </router-link>
          </p>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useToastStore } from "@/stores/toast";
import { computed } from "vue";
import { useFormValidation } from "@/composables/useFormValidation";
import AuthForm from "@/components/forms/AuthForm.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import GoogleOAuthButton from "@/components/ui/GoogleOAuthButton.vue";
import { Mail, Lock, User } from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const toastStore = useToastStore();

const { formData, fieldErrors, setFieldErrors } = useFormValidation({
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const loading = computed(() => authStore.saving);
const error = computed(() => authStore.error);

function validatePasswordMatch() {
  if (formData.value.password !== formData.value.password_confirmation) {
    setFieldErrors({
      password_confirmation: "Les mots de passe ne correspondent pas",
    });
    return false;
  }
  return true;
}

async function handleRegister() {
  setFieldErrors({});

  if (!validatePasswordMatch()) {
    return;
  }

  try {
    await authStore.register(formData.value);
    router.push("/dashboard");
  } catch (err) {
    if (err.response?.data?.errors) {
      setFieldErrors(err.response.data.errors);
    }
  }
}
</script>
