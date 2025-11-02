<template>
  <div class="min-h-screen bg-neutral-100 overflow-x-hidden antialiased">
    <nav
      class="sticky top-0 z-50 bg-neutral-100/80 backdrop-blur-md border-b border-neutral-300 px-4 sm:px-6"
    >
      <div class="max-w-6xl mx-auto py-4 flex items-center justify-between">
        <LogoBrand size="sm" />
        <div class="flex items-center sm:gap-3">
          <router-link
            to="/login"
            class="px-4 py-2 text-xs sm:text-sm font-medium text-neutral-600 hover:text-neutral-950 transition-colors"
          >
            Connexion
          </router-link>
          <router-link
            to="/register"
            class="px-5 py-2 text-xs sm:text-sm font-medium bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-all"
          >
            Commencer
          </router-link>
        </div>
      </div>
    </nav>

    <section class="pt-20 pb-16 px-4 sm:px-6 bg-neutral-100">
      <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <h1
              class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-normal text-neutral-950 leading-tight mb-6"
            >
              Gérez vos réservations en toute simplicité
            </h1>
            <p class="text-lg sm:text-xl text-neutral-700 mb-8 leading-relaxed">
              Créez votre page de réservation, partagez votre lien unique et
              recevez vos réservations automatiquement.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 mb-8">
              <router-link
                to="/register"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-500 text-white rounded-lg font-medium hover:bg-brand-600 transition-all"
              >
                Essayer gratuitement
                <ArrowRight class="w-5 h-5" />
              </router-link>
              <router-link
                to="/login"
                class="inline-flex items-center justify-center px-6 py-3 border border-neutral-400 text-neutral-950 rounded-lg font-medium hover:bg-neutral-200 transition-all"
              >
                Se connecter
              </router-link>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-neutral-700">
              <div class="flex items-center gap-2">
                <CheckCircle class="w-4 h-4 text-success-500" />
                <span>10 réservations gratuites / mois</span>
              </div>
              <div class="flex items-center gap-2">
                <CheckCircle class="w-4 h-4 text-success-500" />
                <span>Sans carte bancaire</span>
              </div>
              <div class="flex items-center gap-2">
                <CheckCircle class="w-4 h-4 text-success-500" />
                <span>Services illimités</span>
              </div>
            </div>
          </div>
          <div class="relative">
            <div
              class="rounded-2xl overflow-hidden border border-neutral-300 shadow-xl bg-neutral-200 p-6 sm:mb-12"
            >
              <DashboardDemo />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-4 sm:px-6 bg-neutral-200">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-950 mb-4"
          >
            Tout ce dont vous avez besoin
          </h2>
          <p class="text-lg text-neutral-700">
            Une solution complète pour gérer vos réservations
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-neutral-300 rounded-xl p-6 border border-neutral-400">
            <div
              class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Calendar class="w-6 h-6 text-brand-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-950 mb-2">
              Disponibilités flexibles
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Définissez vos horaires de travail et gérez vos disponibilités en
              quelques clics.
            </p>
          </div>
          <div class="bg-neutral-300 rounded-xl p-6 border border-neutral-400">
            <div
              class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Bell class="w-6 h-6 text-success-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-950 mb-2">
              Notifications instantanées
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Recevez un email à chaque nouvelle réservation pour ne rien
              manquer.
            </p>
          </div>
          <div class="bg-neutral-300 rounded-xl p-6 border border-neutral-400">
            <div
              class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Link2 class="w-6 h-6 text-brand-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-950 mb-2">
              Page publique unique
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Partagez votre lien personnalisé par email, SMS ou sur vos réseaux
              sociaux.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-4 sm:px-6 bg-neutral-100">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-950 mb-4"
          >
            Comment ça marche
          </h2>
          <p class="text-lg text-neutral-700">En 3 étapes simples</p>
        </div>
        <div class="grid md:grid-cols-3 gap-12">
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              1
            </div>
            <h3 class="text-xl font-semibold text-neutral-950 mb-3">
              Créez vos services
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Ajoutez vos prestations avec leur durée et leur prix
            </p>
          </div>
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              2
            </div>
            <h3 class="text-xl font-semibold text-neutral-950 mb-3">
              Définissez vos horaires
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Configurez vos disponibilités et créneaux horaires
            </p>
          </div>
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              3
            </div>
            <h3 class="text-xl font-semibold text-neutral-950 mb-3">
              Partagez votre lien
            </h3>
            <p class="text-neutral-700 leading-relaxed">
              Vos clients réservent directement en ligne
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-4 sm:px-6 bg-neutral-200">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-950 mb-4"
          >
            Tarification simple
          </h2>
          <p class="text-lg text-neutral-700">
            Commencez gratuitement, passez à Pro quand vous le souhaitez
          </p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <div
            class="bg-neutral-300 rounded-xl p-8 border-2 border-neutral-400"
          >
            <div class="mb-8">
              <h3 class="text-2xl font-semibold text-neutral-950 mb-2">
                Gratuit
              </h3>
              <p class="text-neutral-700">Pour démarrer</p>
            </div>
            <div class="mb-8">
              <div class="flex items-baseline gap-2">
                <span class="text-5xl font-semibold text-neutral-950">0€</span>
                <span class="text-neutral-700">/mois</span>
              </div>
            </div>
            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-800">10 réservations par mois</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-800">Services illimités</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-800">Notifications par email</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-800"
                  >Page publique personnalisée</span
                >
              </li>
            </ul>
            <router-link
              to="/register"
              class="block text-center px-6 py-3 border-2 border-neutral-500 text-neutral-950 font-medium rounded-lg hover:bg-neutral-400 transition-all"
            >
              Commencer gratuitement
            </router-link>
          </div>

          <div
            class="bg-brand-500 text-white rounded-xl p-8 relative shadow-xl"
          >
            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
              <span
                class="bg-yellow-400 text-neutral-950 text-xs font-bold px-4 py-1 rounded-full"
              >
                POPULAIRE
              </span>
            </div>
            <div class="mb-8">
              <h3 class="text-2xl font-semibold mb-2 text-white">Pro</h3>
              <p class="text-white/80">Pour développer votre activité</p>
            </div>
            <div class="mb-8">
              <div class="flex items-baseline gap-2">
                <span class="text-5xl font-semibold text-white">9€</span>
                <span class="text-white/80">/mois</span>
              </div>
            </div>
            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <CheckCircle class="w-5 h-5 flex-shrink-0 mt-0.5 text-white" />
                <span class="text-white">Réservations illimitées</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle class="w-5 h-5 flex-shrink-0 mt-0.5 text-white" />
                <span class="text-white">Services illimités</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle class="w-5 h-5 flex-shrink-0 mt-0.5 text-white" />
                <span class="text-white">Notifications par email</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle class="w-5 h-5 flex-shrink-0 mt-0.5 text-white" />
                <span class="text-white">Page publique personnalisée</span>
              </li>
            </ul>
            <router-link
              to="/register"
              class="block text-center px-6 py-3 bg-white text-brand-600 font-semibold rounded-lg hover:bg-neutral-100 transition-all"
            >
              Choisir Pro
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-6 bg-brand-500 text-white">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-normal mb-6 text-white">
          Prêt à simplifier vos réservations ?
        </h2>
        <p class="text-xl text-white/90 mb-8">
          Essayez gratuitement, sans carte bancaire
        </p>
        <router-link
          to="/register"
          class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-600 font-semibold rounded-lg hover:bg-neutral-100 transition-all text-lg"
        >
          Créer mon compte gratuit
          <ArrowRight class="w-5 h-5" />
        </router-link>
      </div>
    </section>

    <AppFooter />
    <CookieConsent />
  </div>
</template>

<script setup>
import {
  ArrowRight,
  CheckCircle,
  Calendar,
  Bell,
  Link2,
} from "lucide-vue-next";
import LogoBrand from "@/components/layout/LogoBrand.vue";
import DashboardDemo from "@/components/demo/DashboardDemo.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import CookieConsent from "@/components/layout/CookieConsent.vue";
</script>

<style scoped>
section {
  animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
