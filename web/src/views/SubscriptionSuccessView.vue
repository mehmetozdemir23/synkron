<template>
  <div class="min-h-screen bg-neutral-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <div
        class="bg-neutral-200 rounded-2xl shadow-2xl p-6 sm:p-8 text-center border border-neutral-400"
      >
        <div v-if="isProcessing" class="py-8">
          <Loader2 class="w-16 h-16 text-brand-600 animate-spin mx-auto mb-4" />
          <h2 class="text-lg sm:text-xl font-semibold text-neutral-900 mb-2">
            Activation en cours...
          </h2>
          <p class="text-neutral-600 text-sm">
            Veuillez patienter pendant que nous finalisons votre abonnement.
          </p>
        </div>

        <div v-else class="space-y-6">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 bg-success-100 rounded-full flex items-center justify-center mx-auto animate-bounce"
          >
            <CheckCircle class="w-10 h-10 sm:w-12 sm:h-12 text-success-600" />
          </div>

          <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-2">
              Bienvenue dans Pro!
            </h1>
            <p class="text-sm sm:text-base text-neutral-600">
              Votre abonnement a été activé avec succès.
            </p>
          </div>

          <div
            class="bg-brand-50 border border-brand-200 rounded-lg p-5 sm:p-6 text-left"
          >
            <div class="flex items-center gap-2 mb-4">
              <Sparkles class="w-5 h-5 text-brand-600" />
              <p class="font-semibold text-neutral-900">Vous débloquez :</p>
            </div>
            <ul class="space-y-3">
              <li class="flex items-center gap-3 text-sm text-neutral-700">
                <div
                  class="w-2 h-2 bg-brand-600 rounded-full flex-shrink-0"
                ></div>
                <span>Réservations illimitées</span>
              </li>
              <li class="flex items-center gap-3 text-sm text-neutral-700">
                <div
                  class="w-2 h-2 bg-brand-600 rounded-full flex-shrink-0"
                ></div>
                <span>Services illimités</span>
              </li>
              <li class="flex items-center gap-3 text-sm text-neutral-700">
                <div
                  class="w-2 h-2 bg-brand-600 rounded-full flex-shrink-0"
                ></div>
                <span>Notifications par email</span>
              </li>
              <li class="flex items-center gap-3 text-sm text-neutral-700">
                <div
                  class="w-2 h-2 bg-brand-600 rounded-full flex-shrink-0"
                ></div>
                <span>Page de réservation</span>
              </li>
            </ul>
          </div>

          <button
            @click="goToDashboard"
            class="w-full px-6 py-3 bg-gradient-to-r from-brand-600 to-brand-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-200"
          >
            Accéder au dashboard
          </button>

          <p class="text-xs text-neutral-500">
            Redirection automatique dans {{ countdown }} seconde{{
              countdown > 1 ? "s" : ""
            }}...
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useSubscriptionStore } from "@/stores/subscription";
import { CheckCircle, Sparkles, Loader2 } from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const subscriptionStore = useSubscriptionStore();
const isProcessing = ref(true);
const countdown = ref(5);

onMounted(async () => {
  try {
    await authStore.fetchUser();
    await subscriptionStore.fetchStatus();
    isProcessing.value = false;

    const interval = setInterval(() => {
      countdown.value--;
      if (countdown.value <= 0) {
        clearInterval(interval);
        router.push("/dashboard");
      }
    }, 1000);
  } catch (error) {
    console.error(
      "Erreur lors de la vérification de l'authentification:",
      error
    );
    router.push("/login");
  }
});

function goToDashboard() {
  router.push("/dashboard");
}
</script>
