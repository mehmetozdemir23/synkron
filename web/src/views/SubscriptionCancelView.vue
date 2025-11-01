<script setup>
import { useRouter } from "vue-router";
import { XCircle } from "lucide-vue-next";

const router = useRouter();

function goBack() {
  router.push("/dashboard");
}
</script>

<template>
  <div class="min-h-screen bg-neutral-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <div
        class="bg-neutral-200 rounded-2xl shadow-2xl p-6 sm:p-8 text-center border border-neutral-400"
      >
        <div
          class="w-16 h-16 sm:w-20 sm:h-20 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-6"
        >
          <XCircle class="w-10 h-10 sm:w-12 sm:h-12 text-neutral-400" />
        </div>

        <h1 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-3">
          Paiement annulé
        </h1>

        <p class="text-sm sm:text-base text-neutral-600 mb-8">
          Vous avez annulé le processus de paiement. Aucun montant n'a été
          débité.
        </p>

        <button
          @click="goBack"
          class="w-full px-6 py-3 bg-neutral-900 text-white rounded-lg font-semibold hover:bg-neutral-800 transition-colors mb-4"
        >
          Retour au dashboard
        </button>

        <p class="text-sm text-neutral-500">
          Vous pourrez passer Pro à tout moment depuis votre dashboard.
        </p>
      </div>
    </div>
  </div>
</template>
