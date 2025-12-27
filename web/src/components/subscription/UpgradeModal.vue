<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        @click.self="close"
      >
        <div
          class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-neutral-200"
        >
          <div
            class="px-4 sm:px-6 py-4 sm:py-5 flex items-start sm:items-center justify-between gap-3 border-b border-neutral-200"
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
              <AlertCircle
                class="w-5 h-5 text-error-600 flex-shrink-0 mt-0.5"
              />
              <div class="flex-1">
                <p class="text-sm font-semibold text-error-700">
                  Limite mensuelle atteinte
                </p>
                <p class="text-xs text-error-600 mt-1">
                  Passez Pro pour continuer à recevoir des réservations.
                </p>
              </div>
            </div>

            <div class="space-y-3">
              <p
                class="text-xs font-semibold text-neutral-700 uppercase tracking-wide"
              >
                Avec Pro vous débloquez
              </p>

              <div class="space-y-2">
                <div
                  class="flex gap-3 p-3 bg-neutral-50 rounded-lg border border-neutral-200"
                >
                  <div
                    class="w-10 h-10 rounded-lg bg-brand-200 flex items-center justify-center flex-shrink-0"
                  >
                    <Infinity class="w-6 h-6 text-brand-700" />
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-neutral-900">
                      Réservations illimitées
                    </p>
                    <p class="text-xs text-neutral-600">
                      Acceptez autant de réservations que vous voulez
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-5 bg-neutral-50 rounded-xl border border-neutral-200">
              <div class="text-center space-y-3">
                <div class="flex items-baseline justify-center gap-1">
                  <span class="text-4xl font-bold text-neutral-900">9€</span>
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
              class="w-full py-3 px-4 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <Crown class="w-4 h-4 stroke-[2.6]" />
              <span v-if="processing">Redirection...</span>
              <span v-else>Passer Pro maintenant</span>
            </button>

            <p class="text-xs text-neutral-600 text-center">
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
import { X, Infinity, Crown, AlertCircle } from "lucide-vue-next";
import { logError } from "@/utils/logger";

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
    logError("UpgradeModal.handleUpgrade", error);
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
