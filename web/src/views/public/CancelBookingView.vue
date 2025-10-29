<template>
  <div
    class="min-h-screen bg-neutral-100 flex flex-col"
  >
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center p-4 py-6 sm:py-8">
      <div class="w-full max-w-md bg-neutral-200 rounded-2xl border border-neutral-400 shadow-lg p-6 sm:p-8 flex flex-col">
        <div v-if="loading" class="text-center py-12">
          <div
            class="w-12 h-12 border-4 border-brand-200 border-t-brand-600 rounded-full animate-spin mx-auto mb-4"
          ></div>
          <p class="text-sm text-neutral-600">Traitement en cours...</p>
        </div>

        <div v-else-if="success" class="text-center">
          <div
            class="w-16 h-16 bg-success-50 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <CheckCircle class="w-8 h-8 text-success-600" />
          </div>
          <h1 class="text-2xl font-bold text-neutral-900 mb-1">
            Réservation annulée
          </h1>
          <p class="text-sm text-neutral-600 mb-6">
            Votre réservation a été annulée avec succès. Un email de
            confirmation vous a été envoyé.
          </p>
          <div
            v-if="booking"
            class="bg-gradient-to-br from-neutral-50 to-neutral-50/50 rounded-lg p-4 mb-6 text-left border border-neutral-200"
          >
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Briefcase class="w-4 h-4 text-neutral-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Service</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ booking.service?.name }}
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Calendar class="w-4 h-4 text-neutral-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Date</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ formatDate(booking.start_at) }}
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Clock class="w-4 h-4 text-neutral-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Heure</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ formatTime(booking.start_at) }} - {{ formatTime(booking.end_at) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else-if="error" class="text-center">
          <div
            class="w-16 h-16 bg-error-50 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <XCircle class="w-8 h-8 text-error-600" />
          </div>
          <h1 class="text-2xl font-bold text-neutral-900 mb-1">Erreur</h1>
          <p class="text-sm text-neutral-600 mb-6">{{ error }}</p>
        </div>

        <div v-else class="text-center">
          <div
            class="w-16 h-16 bg-warning-50 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <AlertCircle class="w-8 h-8 text-warning-600" />
          </div>
          <h1 class="text-2xl font-bold text-neutral-900 mb-1">
            Annuler votre réservation
          </h1>
          <p class="text-sm text-neutral-600 mb-6">
            Êtes-vous sûr de vouloir annuler cette réservation ?
          </p>

          <div
            v-if="booking"
            class="bg-gradient-to-br from-neutral-50 to-neutral-50/50 rounded-lg p-4 mb-6 text-left border border-neutral-200"
          >
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Briefcase class="w-4 h-4 text-brand-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Service</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ booking.service?.name }}
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Calendar class="w-4 h-4 text-brand-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Date</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ formatDate(booking.start_at) }}
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Clock class="w-4 h-4 text-brand-600" />
                </div>
                <div>
                  <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Heure</p>
                  <p class="text-sm font-semibold text-neutral-900 mt-0.5">
                    {{ formatTime(booking.start_at) }} - {{ formatTime(booking.end_at) }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="flex flex-col sm:flex-row gap-3">
            <button
              @click="handleCancel"
              :disabled="canceling"
              class="flex-1 px-4 py-2.5 bg-error-600 text-white rounded-lg font-medium hover:bg-error-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed active:scale-95"
            >
              {{ canceling ? "Annulation..." : "Oui, annuler" }}
            </button>
            <button
              @click="goBack"
              class="flex-1 px-4 py-2.5 bg-neutral-100 text-neutral-900 rounded-lg font-medium hover:bg-neutral-200 transition-colors active:scale-95"
            >
              Retour
            </button>
          </div>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { publicAPI } from "@/services/api";
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import {
  CheckCircle,
  XCircle,
  AlertCircle,
  Calendar,
  Clock,
  Briefcase,
} from "lucide-vue-next";

const route = useRoute();
const router = useRouter();

const token = ref(route.params.token);
const booking = ref(null);
const loading = ref(true);
const success = ref(false);
const error = ref(null);
const canceling = ref(false);

function formatDate(dateString) {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat("fr-FR", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  }).format(date);
}

function formatTime(dateString) {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat("fr-FR", {
    hour: "2-digit",
    minute: "2-digit",
  }).format(date);
}

async function fetchBooking() {
  loading.value = true;
  error.value = null;

  try {
    loading.value = false;
  } catch (err) {
    error.value = err.response?.data?.message || "Lien invalide ou expiré";
    loading.value = false;
  }
}

async function handleCancel() {
  canceling.value = true;
  error.value = null;

  try {
    const response = await publicAPI.cancelBooking(token.value);
    booking.value = response.data.booking;
    success.value = true;
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      "Une erreur est survenue lors de l'annulation";
  } finally {
    canceling.value = false;
  }
}

function goBack() {
  router.go(-1);
}

onMounted(() => {
  if (!token.value) {
    error.value = "Lien invalide";
    loading.value = false;
  } else {
    fetchBooking();
  }
});
</script>
