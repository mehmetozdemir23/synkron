<template>
  <Transition name="slide-up">
    <div
      v-if="!consentGiven"
      class="fixed bottom-0 left-0 right-0 z-50 bg-neutral-100 border-t border-neutral-300 shadow-2xl"
    >
      <div class="max-w-7xl mx-auto px-4 py-4 sm:py-5 md:py-6">
        <div
          class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
        >
          <div class="flex-1">
            <div class="flex items-start gap-3">
              <div
                class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0"
              >
                <Cookie class="w-5 h-5 text-brand-600" />
              </div>
              <div>
                <h3 class="text-sm font-semibold text-neutral-900 mb-1">
                  Respect de votre vie privée
                </h3>
                <p class="text-xs sm:text-sm text-neutral-600 leading-relaxed">
                  Nous utilisons uniquement des cookies essentiels pour le
                  fonctionnement du site (authentification, session). Aucun
                  cookie de tracking ou de publicité.
                  <router-link
                    to="/privacy"
                    class="text-brand-600 hover:text-brand-700 font-medium underline ml-1"
                  >
                    En savoir plus
                  </router-link>
                </p>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <button
              @click="rejectCookies"
              class="flex-1 sm:flex-initial px-4 py-2.5 min-h-[44px] text-sm font-medium text-neutral-700 bg-neutral-100 hover:bg-neutral-200 rounded-lg transition-colors"
            >
              Refuser
            </button>
            <button
              @click="acceptCookies"
              class="flex-1 sm:flex-initial px-4 py-2.5 min-h-[44px] text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 rounded-lg transition-colors"
            >
              Accepter
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Cookie } from "lucide-vue-next";

const consentGiven = ref(true);

onMounted(() => {
  const consent = localStorage.getItem("cookie_consent");
  if (consent === null) {
    consentGiven.value = false;
  }
});

function acceptCookies() {
  localStorage.setItem("cookie_consent", "accepted");
  localStorage.setItem("cookie_consent_date", new Date().toISOString());
  consentGiven.value = true;
}

function rejectCookies() {
  localStorage.setItem("cookie_consent", "rejected");
  localStorage.setItem("cookie_consent_date", new Date().toISOString());
  consentGiven.value = true;
}
</script>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}

.slide-up-enter-from {
  transform: translateY(100%);
  opacity: 0;
}

.slide-up-leave-to {
  transform: translateY(100%);
  opacity: 0;
}
</style>
