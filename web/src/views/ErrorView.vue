<template>
  <div class="min-h-screen bg-neutral-50 flex flex-col">
    <div class="flex-1 flex items-center justify-center px-4">
      <div class="max-w-md w-full text-center">
        <div
          class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-error-100 flex items-center justify-center mx-auto mb-6"
        >
          <XCircle class="w-10 h-10 sm:w-12 sm:h-12 text-error-600" />
        </div>

        <h1 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-3">
          Une erreur est survenue
        </h1>

        <p class="text-sm sm:text-base text-neutral-600 mb-8">
          Nous sommes désolés, une erreur inattendue s'est produite. Veuillez
          réessayer dans quelques instants.
        </p>

        <div
          v-if="errorMessage"
          class="mb-8 p-4 bg-error-50 border border-error-200 rounded-lg text-left"
        >
          <p class="text-xs font-mono text-error-700">{{ errorMessage }}</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <BaseButton
            @click="reload"
            variant="secondary"
            class="w-full sm:w-auto"
          >
            <RefreshCw class="w-4 h-4" />
            Réessayer
          </BaseButton>
          <BaseButton
            @click="goHome"
            variant="primary"
            class="w-full sm:w-auto"
          >
            <Home class="w-4 h-4" />
            Retour à l'accueil
          </BaseButton>
        </div>

        <div class="mt-8 pt-8 border-t border-neutral-200">
          <p class="text-xs text-neutral-500">
            Le problème persiste ?
            <router-link
              to="/"
              class="text-brand-600 hover:text-brand-700 font-medium"
            >
              Contactez notre support
            </router-link>
          </p>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import BaseButton from "@/components/ui/BaseButton.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import { XCircle, RefreshCw, Home } from "lucide-vue-next";

const router = useRouter();
const route = useRoute();
const errorMessage = ref("");

onMounted(() => {
  if (route.query.message) {
    errorMessage.value = route.query.message;
  }
});

function reload() {
  window.location.reload();
}

function goHome() {
  router.push("/");
}
</script>
