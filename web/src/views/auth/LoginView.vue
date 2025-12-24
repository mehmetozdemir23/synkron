<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
      <div class="w-full max-w-md">
        <div class="mb-6 sm:mb-8">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-2">
            Connexion
          </h1>
          <p class="text-base text-neutral-600">
            Accédez à votre tableau de bord en un seul clic.
          </p>
        </div>

        <div class="transition-all animate-fade-in">
          <div class="space-y-5">
            <AuthForm :error="error" :loading="loading" @submit="handleLogin">
              <BaseInput
                v-model="formData.email"
                type="email"
                label="Adresse email"
                placeholder="vous@exemple.com"
                :icon-component="Mail"
                :error="fieldErrors.email"
                required
              />

              <div>
                <div class="flex items-center justify-between mb-2">
                  <label class="text-sm font-medium text-neutral-700"
                    >Mot de passe</label
                  >
                  <router-link
                    to="/forgot-password"
                    class="text-xs text-brand-600 hover:text-brand-700 font-medium transition-colors"
                  >
                    Oublié ?
                  </router-link>
                </div>
                <BaseInput
                  v-model="formData.password"
                  type="password"
                  placeholder="••••••••"
                  :icon-component="Lock"
                  :error="fieldErrors.password"
                  required
                />
              </div>

              <template #submit-label>Se connecter</template>
            </AuthForm>
          </div>

          <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-neutral-300"></div>
            </div>
            <div class="relative flex justify-center">
              <span
                class="px-3 bg-neutral-100 text-sm text-neutral-600 font-medium"
                >ou</span
              >
            </div>
          </div>

          <div>
            <GoogleOAuthButton />
          </div>
        </div>

        <div class="text-center mt-6">
          <p class="text-sm text-neutral-600">
            Nouveau ici ?
            <router-link
              to="/register"
              class="text-brand-600 hover:text-brand-700 font-semibold transition-colors"
            >
              Créer un compte gratuit
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
import { Mail, Lock } from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const toastStore = useToastStore();

const { formData, fieldErrors, setFieldErrors } = useFormValidation({
  email: "",
  password: "",
});

const loading = computed(() => authStore.saving);
const error = computed(() => authStore.error);

async function handleLogin() {
  setFieldErrors({});

  try {
    await authStore.login(formData.value);
    router.push("/dashboard");
  } catch (err) {
    if (err.response?.data?.errors) {
      setFieldErrors(err.response.data.errors);
    }
  }
}
</script>
