<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        @click.self="close"
      >
        <div class="bg-neutral-200 rounded-2xl shadow-2xl max-w-md w-full border border-neutral-400">
          <div
            class="px-4 sm:px-6 py-4 sm:py-5 flex items-start sm:items-center justify-between gap-3 border-b border-neutral-400"
          >
            <div class="flex-1 min-w-0">
              <h2 class="text-lg sm:text-xl font-bold text-neutral-900">
                Passez Pro
              </h2>
              <p class="text-xs sm:text-sm text-neutral-600 mt-0.5">
                Débloquez les réservations illimitées
              </p>
            </div>
            <button
              @click="close"
              :disabled="processing"
              class="p-2 hover:bg-neutral-100 rounded-lg transition-colors disabled:opacity-50 flex-shrink-0"
            >
              <X class="w-5 h-5 text-neutral-500" />
            </button>
          </div>

          <div class="p-4 sm:p-6 space-y-6">
            <div
              v-if="!subscriptionStore.canBook"
              class="flex items-start gap-3 p-4 bg-error-50 border border-error-200 rounded-lg"
            >
              <Zap class="w-5 h-5 text-error-600 flex-shrink-0 mt-0.5" />
              <div class="flex-1">
                <p class="text-sm font-semibold text-error-700">
                  Limite mensuelle atteinte
                </p>
                <p class="text-xs text-error-600 mt-1">
                  Passez Pro pour continuer à recevoir des réservations.
                </p>
              </div>
            </div>

            <div class="space-y-2.5">
              <p
                class="text-xs font-semibold text-neutral-600 uppercase tracking-wide"
              >
                Comparaison rapide
              </p>

              <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-neutral-50 rounded-lg">
                  <p class="text-xs font-semibold text-neutral-600 mb-2">
                    Gratuit
                  </p>
                  <p class="text-lg font-bold text-neutral-900">10</p>
                  <p class="text-xs text-neutral-600">réservations/mois</p>
                </div>

                <div class="p-3 bg-brand-50 border border-brand-200 rounded-lg">
                  <p class="text-xs font-semibold text-brand-600 mb-2">Pro</p>
                  <p class="text-lg font-bold text-brand-900">∞</p>
                  <p class="text-xs text-brand-700">illimité</p>
                </div>
              </div>
            </div>

            <div
              class="relative pt-4 pb-6 px-4 border-2 border-brand-200 bg-gradient-to-br from-brand-50 to-accent-50 rounded-xl"
            >
              <div
                class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-gradient-to-r from-brand-600 to-accent-600 text-white text-xs font-semibold rounded-full"
              >
                Meilleure offre
              </div>

              <div class="text-center space-y-2">
                <div class="flex items-baseline justify-center gap-1">
                  <span class="text-3xl sm:text-4xl font-bold text-neutral-900">9€</span>
                  <span class="text-sm text-neutral-600">/mois</span>
                </div>
                <p class="text-xs text-neutral-600">
                  Sans engagement • Annulation facile
                </p>
              </div>
            </div>

            <button
              @click="handleUpgrade"
              :disabled="processing"
              class="w-full py-2.5 px-4 bg-gradient-to-r from-brand-600 to-brand-500 text-white text-sm font-medium rounded-lg hover:shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <Sparkles v-if="!processing" class="w-4 h-4" />
              <span v-if="processing">Redirection...</span>
              <span v-else>Passer Pro maintenant</span>
            </button>

            <p class="text-xs text-neutral-500 text-center">
              Paiement sécurisé par Stripe
            </p>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref } from "vue";
import { useSubscriptionStore } from "@/stores/subscription";
import { X, Check, Sparkles, Zap } from "lucide-vue-next";

const props = defineProps({
  show: Boolean,
});

const emit = defineEmits(["close"]);

const subscriptionStore = useSubscriptionStore();
const processing = ref(false);

const handleUpgrade = async () => {
  processing.value = true;
  try {
    await subscriptionStore.checkout();
  } catch (error) {
    console.error("Erreur upgrade:", error);
    processing.value = false;
  }
};

function close() {
  if (!processing.value) {
    emit("close");
  }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active > div,
.modal-leave-active > div {
  transition: transform 0.3s ease;
}

.modal-enter-from > div,
.modal-leave-to > div {
  transform: scale(0.95);
}
</style>
