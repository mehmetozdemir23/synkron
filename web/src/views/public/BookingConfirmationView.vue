<template>
  <div class="flex flex-col min-h-screen bg-neutral-50">
    <PublicHeader />

    <div class="flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
      <div class="w-full max-w-md">
        <div v-if="loading" class="text-center py-12">
          <div
            class="w-12 h-12 border-4 border-brand-200 border-t-brand-500 rounded-full animate-spin mx-auto mb-4"
          ></div>
          <p class="text-sm text-neutral-600">
            Chargement de votre réservation...
          </p>
        </div>

        <div v-else-if="error" class="text-center animate-fade-in">
          <div
            class="bg-neutral-200 rounded-2xl border border-neutral-400 shadow-md p-8 mb-6"
          >
            <div
              class="w-16 h-16 bg-error-100 rounded-full flex items-center justify-center mx-auto mb-4"
            >
              <AlertCircle class="w-8 h-8 text-error-600" />
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-2">
              Erreur
            </h1>
            <p class="text-base text-neutral-600">{{ error }}</p>
          </div>

          <router-link
            to="/"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 active:bg-brand-700 text-white rounded-lg font-medium transition-colors"
          >
            Retour à l'accueil
          </router-link>
        </div>

        <div v-else class="animate-fade-in">
          <div
            class="bg-neutral-200 rounded-2xl border border-neutral-400 shadow-md p-6 sm:p-8"
          >
            <div class="text-center mb-6">
              <div
                class="w-14 h-14 bg-warning-100 rounded-full flex items-center justify-center mx-auto mb-3"
              >
                <Clock class="w-7 h-7 text-warning-600" />
              </div>
              <h1 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-2">
                Demande bien reçue !
              </h1>
              <p class="text-sm text-neutral-600">
                Votre demande est en attente de confirmation par le
                professionnel.
              </p>
            </div>

            <div class="bg-neutral-500 rounded-lg p-3 mb-6">
              <div class="flex items-center gap-2 text-neutral-900 font-medium">
                <Mail class="w-4 h-4 flex-shrink-0" />
                <p class="text-xs">
                  Vous recevrez un email à
                  <span class="font-semibold">{{
                    bookingData.client_email
                  }}</span>
                  dès validation.
                </p>
              </div>
            </div>

            <div class="mb-6">
              <h2 class="text-sm font-semibold text-neutral-900 mb-3">
                Détails de la réservation
              </h2>

              <div class="space-y-3">
                <div class="flex gap-2.5">
                  <div
                    class="w-9 h-9 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"
                  >
                    <Briefcase class="w-4 h-4 text-brand-600" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-neutral-600">Service</p>
                    <p class="text-sm font-semibold text-neutral-900">
                      {{ bookingData.service_name }}
                    </p>
                  </div>
                </div>

                <div class="flex gap-2.5">
                  <div
                    class="w-9 h-9 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"
                  >
                    <Calendar class="w-4 h-4 text-brand-600" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-neutral-600">Date</p>
                    <p class="text-sm font-semibold text-neutral-900">
                      {{ formatDate(bookingData.start_at) }}
                    </p>
                  </div>
                </div>

                <div class="flex gap-2.5">
                  <div
                    class="w-9 h-9 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"
                  >
                    <Clock class="w-4 h-4 text-brand-600" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-neutral-600">Heure</p>
                    <p class="text-sm font-semibold text-neutral-900">
                      {{ formatTime(bookingData.start_at) }}
                    </p>
                  </div>
                </div>

                <div v-if="bookingData.client_name" class="flex gap-2.5 pt-1">
                  <div
                    class="w-9 h-9 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"
                  >
                    <User class="w-4 h-4 text-brand-600" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-neutral-600">Nom</p>
                    <p class="text-sm font-semibold text-neutral-900">
                      {{ bookingData.client_name }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="text-center space-y-2.5 border-t border-neutral-300 pt-6"
            >
              <router-link
                v-if="professionalSlug"
                :to="{
                  name: 'public-professional',
                  params: { slug: professionalSlug },
                }"
                class="block px-6 py-2.5 bg-brand-500 hover:bg-brand-600 active:bg-brand-700 text-white rounded-lg font-medium transition-colors"
              >
                Retour au profil
              </router-link>

              <router-link
                to="/"
                class="inline-flex items-center gap-1 py-2.5 text-sm text-brand-600 hover:text-brand-700 font-medium transition-colors"
              >
                <ArrowLeft class="w-4 h-4" />
                Revenir à l'accueil
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { publicAPI } from "@/services/api";
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import {
  Calendar,
  Clock,
  Briefcase,
  User,
  AlertCircle,
  Mail,
  ArrowLeft,
} from "lucide-vue-next";

const route = useRoute();

const bookingData = ref({
  client_name: "",
  client_email: "",
  service_name: "",
  start_at: null,
});
const professionalSlug = ref("");
const loading = ref(true);
const error = ref("");

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
  error.value = "";

  try {
    const bookingId = route.query.booking_id;
    if (!bookingId) {
      throw new Error("ID de réservation manquant");
    }

    const response = await publicAPI.getBooking(bookingId);
    const booking = response.data.booking;

    bookingData.value = {
      client_name: booking.client_name,
      client_email: booking.client_email,
      service_name: booking.service.name,
      start_at: booking.start_at,
    };

    if (booking.professional) {
      professionalSlug.value = booking.professional.slug;
    }
  } catch (err) {
    error.value = "Impossible de charger les détails de la réservation";
    console.error("Error fetching booking:", err);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  fetchBooking();
});
</script>
