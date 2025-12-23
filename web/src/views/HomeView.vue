<template>
  <div class="min-h-screen bg-neutral-100 overflow-x-hidden antialiased">
    <nav
      class="sticky top-0 z-50 bg-neutral-100/80 backdrop-blur-md border-b border-neutral-300 px-4 sm:px-6"
    >
      <div class="max-w-6xl mx-auto py-4 flex items-center justify-between">
        <LogoBrand size="sm" />
        <div class="flex items-center gap-2 sm:gap-3">
          <router-link
            to="/login"
            class="hidden sm:block px-2 sm:px-4 py-2 text-xs sm:text-sm font-medium text-neutral-600 hover:text-neutral-900 transition-colors"
          >
            Connexion
          </router-link>
          <router-link
            to="/register"
            class="px-4 sm:px-5 pt-2 pb-2.5 text-xs sm:text-sm font-bold bg-brand-600 text-neutral-100 rounded-lg hover:bg-brand-600 transition-all"
          >
            Commencer
          </router-link>
        </div>
      </div>
    </nav>

    <section
      class="min-h-[calc(100vh-80px)] flex items-center px-4 sm:px-6 bg-neutral-100 py-16"
    >
      <div class="max-w-6xl mx-auto w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="self-start lg:mt-8">
            <h1
              class="text-3xl sm:text-4xl md:text-5xl font-medium text-neutral-900 leading-tight mb-6"
            >
              Gérez vos réservations en toute
              <span class="relative inline-block">
                <span class="relative z-10 text-brand-600 font-semibold"
                  >simplicité</span
                >
                <span
                  class="absolute bottom-0 left-0 w-full h-5 bg-blue-100 -z-0"
                  aria-hidden="true"
                ></span> </span
              >.
            </h1>
            <p
              class="text-lg sm:text-xl text-neutral-700 font-medium mb-8 leading-relaxed"
            >
              Créez votre page de réservation, partagez votre lien unique et
              recevez vos réservations automatiquement.
            </p>
            <div
              class="flex flex-col justify-center sm:justify-start sm:items-center sm:flex-row gap-4 mb-8"
            >
              <router-link
                to="/register"
                class="inline-flex items-center justify-center gap-2 pl-6 pr-4 pt-3 pb-3.5 bg-brand-600 text-neutral-100 rounded-lg font-bold hover:bg-brand-600 transition-all"
              >
                Essayer gratuitement
                <ArrowRight class="w-5 h-5 mt-0.5" />
              </router-link>
              <router-link
                to="/login"
                class="inline-flex items-center justify-center px-6 pt-3 pb-3.5 border-2 border-neutral-200 text-neutral-900 rounded-lg font-medium hover:border-brand-500 hover:text-brand-600 hover:bg-brand-50 transition-all"
              >
                Se connecter
              </router-link>
            </div>
            <div class="flex flex-wrap justify-center sm:justify-start gap-6">
              <div
                class="inline-flex items-center gap-1.5 text-neutral-700 text-sm font-medium"
              >
                <CheckCircle class="w-4 h-4 flex-shrink-0 text-success-600" />
                <span>10 réservations gratuites / mois</span>
              </div>
              <div
                class="inline-flex items-center gap-1.5 text-neutral-700 text-sm font-medium"
              >
                <CheckCircle class="w-4 h-4 flex-shrink-0 text-success-600" />
                <span>Sans CB</span>
              </div>
              <div
                class="inline-flex items-center gap-1.5 text-neutral-700 text-sm font-medium"
              >
                <CheckCircle class="w-4 h-4 flex-shrink-0 text-success-600" />
                <span>Services illimités</span>
              </div>
            </div>
          </div>
          <DashboardDemo />
        </div>
      </div>
    </section>

    <section class="py-20 px-4 sm:px-6 bg-neutral-50">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-900 mb-4"
          >
            Tout ce dont vous avez besoin
          </h2>
          <p class="text-lg text-neutral-600">
            Une solution complète pour gérer vos réservations
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-neutral-100 rounded-xl p-6 shadow-md">
            <div
              class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Calendar class="w-6 h-6 text-brand-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-2">
              Disponibilités flexibles
            </h3>
            <p class="text-neutral-600 leading-relaxed">
              Définissez vos horaires de travail et gérez vos disponibilités en
              quelques clics.
            </p>
          </div>
          <div class="bg-neutral-100 rounded-xl p-6 shadow-md">
            <div
              class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Bell class="w-6 h-6 text-success-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-2">
              Notifications instantanées
            </h3>
            <p class="text-neutral-600 leading-relaxed">
              Recevez un email à chaque nouvelle réservation pour ne rien
              manquer.
            </p>
          </div>
          <div class="bg-neutral-100 rounded-xl p-6 shadow-md">
            <div
              class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4"
            >
              <Link2 class="w-6 h-6 text-brand-600" />
            </div>
            <h3 class="text-lg font-semibold text-neutral-900 mb-2">
              Page publique unique
            </h3>
            <p class="text-neutral-600 leading-relaxed">
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
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-900 mb-4"
          >
            Comment ça marche
          </h2>
          <p class="text-lg text-neutral-600">En 3 étapes simples</p>
        </div>
        <div class="grid md:grid-cols-3 gap-12">
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              1
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-3">
              Créez vos services
            </h3>
            <p class="text-neutral-600 leading-relaxed">
              Ajoutez vos prestations avec leur durée et leur prix
            </p>
          </div>
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              2
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-3">
              Définissez vos horaires
            </h3>
            <p class="text-neutral-600 leading-relaxed">
              Configurez vos disponibilités et créneaux horaires
            </p>
          </div>
          <div class="text-center">
            <div
              class="w-16 h-16 bg-brand-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mx-auto mb-6"
            >
              3
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-3">
              Partagez votre lien
            </h3>
            <p class="text-neutral-600 leading-relaxed">
              Vos clients réservent directement en ligne
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-4 sm:px-6 bg-neutral-50">
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-normal text-neutral-900 mb-4"
          >
            Tarification simple
          </h2>
          <p class="text-lg text-neutral-600">
            Commencez gratuitement, passez à Pro quand vous le souhaitez
          </p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <div class="bg-neutral-100 rounded-xl p-8 shadow-md">
            <div class="mb-8">
              <h3 class="text-2xl font-semibold text-neutral-900 mb-2">
                Gratuit
              </h3>
              <p class="text-neutral-600">Pour démarrer</p>
            </div>
            <div class="mb-8">
              <div class="flex items-baseline gap-2">
                <span class="text-5xl font-semibold text-neutral-900">0€</span>
                <span class="text-neutral-600">/mois</span>
              </div>
            </div>
            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-900">10 réservations par mois</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-900">Services illimités</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-900">Notifications par email</span>
              </li>
              <li class="flex items-start gap-3">
                <CheckCircle
                  class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5"
                />
                <span class="text-neutral-900">Lien de réservation unique</span>
              </li>
            </ul>
            <router-link
              to="/register"
              class="block text-center px-6 py-3 border-2 border-neutral-400 text-neutral-900 font-medium rounded-lg hover:bg-neutral-200 transition-all"
            >
              Commencer gratuitement
            </router-link>
          </div>

          <div
            class="bg-gradient-to-br from-brand-600 to-brand-700 text-white rounded-xl p-8 relative shadow-xl"
          >
            <div
              class="absolute -top-3.5 left-1/2 -translate-x-1/2 -translate-y-0.5 rounded-full pl-1.5 pr-3.5 py-1.5 flex items-center bg-amber-300 text-neutral-800"
            >
              <Check class="mt-px h-4" />
              <span class="text-sm font-semibold font-mono">
                OFFRE RECOMMANDEE
              </span>
            </div>
            <div class="mb-8">
              <h3 class="text-2xl font-bold mb-2 text-white">Pro</h3>
              <p class="text-white">Pour développer votre activité</p>
            </div>
            <div class="mb-8">
              <div class="flex items-baseline gap-2">
                <span class="text-5xl font-semibold text-white">9€</span>
                <span class="text-white/80">/mois</span>
              </div>
            </div>
            <ul class="space-y-4 mb-8 font-semibold">
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
                <span class="text-white">Lien de réservation unique</span>
              </li>
            </ul>
            <router-link
              to="/register"
              class="block text-center px-6 py-3 bg-white text-brand-700 font-bold rounded-lg hover:bg-neutral-50 hover:shadow-lg transition-all shadow-md"
            >
              Choisir Pro
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-6 bg-gradient-to-r from-brand-600 to-brand-700">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl font-bold mb-6 text-white">
          Prêt à simplifier vos réservations ?
        </h2>
        <p class="text-lg sm:text-xl text-white/90 mb-8">
          Essayez gratuitement, sans carte bancaire
        </p>
        <router-link
          to="/register"
          class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-lg hover:bg-neutral-50 hover:scale-105 hover:shadow-2xl transition-all text-lg shadow-xl"
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
  Check,
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
