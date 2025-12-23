<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    
    <div class="flex-1 flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md text-center animate-fade-in">
        
        <div class="mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-error-50 mb-6">
            <AlertCircle class="w-8 h-8 text-error-600" />
          </div>
          <h1 class="text-6xl sm:text-7xl font-bold text-neutral-900 mb-4">404</h1>
          <h2 class="text-2xl font-bold text-neutral-900 mb-3">
            Page non trouvée
          </h2>
          <p class="text-base text-neutral-600">
            La page que vous recherchez n'existe pas ou a été supprimée.
          </p>
        </div>

        
        <div class="flex flex-col gap-3 mb-8">
          <button
            @click="goHome"
            class="w-full px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-white rounded-lg font-medium transition-colors inline-flex items-center justify-center gap-2"
          >
            <Home class="w-4 h-4" />
            Retourner à l'accueil
          </button>
          <button
            @click="goBack"
            class="w-full px-4 py-2.5 border border-neutral-200 text-neutral-600 hover:bg-neutral-50 rounded-lg font-medium transition-colors inline-flex items-center justify-center gap-2"
          >
            <ArrowLeft class="w-4 h-4" />
            Revenir en arrière
          </button>
        </div>

        
        <p class="text-sm text-neutral-600">
          Besoin d'aide ?
          <router-link
            to="/"
            class="text-brand-600 hover:text-brand-700 font-medium transition-colors"
          >
            Contactez le support
          </router-link>
        </p>
      </div>
    </div>

    
    <AppFooter />
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import { AlertCircle, ArrowLeft, Home } from "lucide-vue-next";

const router = useRouter();

function goBack() {
  router.go(-1);
}

function goHome() {
  router.push("/");
}
</script>
