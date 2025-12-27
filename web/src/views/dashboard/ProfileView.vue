<template>
  <DashboardLayout>
    <template #header>
      <div
        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4"
      >
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-normal text-neutral-900">Profil</h1>
          <p class="text-sm text-neutral-600 mt-1">
            Gérez vos informations personnelles et votre abonnement
          </p>
        </div>
      </div>
    </template>

    <div class="w-full space-y-6">
      <section class="bg-white rounded-xl border border-neutral-200 p-6 sm:p-7">
        <h2 class="text-lg font-semibold text-neutral-900 mb-5">
          Informations personnelles
        </h2>

        <form @submit.prevent="updateProfile" class="space-y-4 sm:space-y-5">
          <BaseInput
            v-model="formData.firstname"
            label="Prénom"
            placeholder="Marie"
            required
            :icon-component="User"
          />

          <BaseInput
            v-model="formData.lastname"
            label="Nom"
            placeholder="Dupont"
            required
            :icon-component="User"
          />

          <div>
            <label class="block text-sm font-semibold text-neutral-700 mb-2"
              >Adresse email</label
            >
            <div
              class="flex items-center gap-3 px-4 py-3 bg-neutral-50 border border-neutral-300 rounded-xl"
            >
              <Mail class="w-5 h-5 text-neutral-600" />
              <span class="text-sm font-medium text-neutral-700">{{
                formData.email
              }}</span>
            </div>
            <p class="text-xs text-neutral-600 mt-2 font-medium">
              Non modifiable
            </p>
          </div>

          <BaseInput
            v-model="formData.business_name"
            label="Entreprise / Cabinet"
            placeholder="Cabinet Marie Dupont"
            :icon-component="Building2"
          />

          <BaseInput
            v-model="formData.activity"
            label="Spécialité"
            placeholder="Psychologue, Coach..."
            :icon-component="BriefcaseBusiness"
          />

          <div>
            <label class="block text-sm font-semibold text-neutral-700 mb-2"
              >Fuseau horaire</label
            >
            <div class="relative">
              <Clock
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-600 pointer-events-none"
              />
              <select
                v-model="formData.timezone"
                class="w-full pl-11 pr-10 py-3 min-h-[44px] bg-neutral-50 border border-neutral-300 rounded-xl text-sm font-medium text-neutral-900 focus:outline-none focus:border-brand-500 focus:bg-neutral-200 hover:border-neutral-400 transition-all duration-200 appearance-none cursor-pointer"
                required
              >
                <optgroup label="Europe">
                  <option value="Europe/Paris">Paris (GMT+1)</option>
                  <option value="Europe/London">Londres (GMT+0)</option>
                  <option value="Europe/Berlin">Berlin (GMT+1)</option>
                  <option value="Europe/Madrid">Madrid (GMT+1)</option>
                  <option value="Europe/Rome">Rome (GMT+1)</option>
                  <option value="Europe/Brussels">Bruxelles (GMT+1)</option>
                  <option value="Europe/Zurich">Zurich (GMT+1)</option>
                  <option value="Europe/Amsterdam">Amsterdam (GMT+1)</option>
                </optgroup>
                <optgroup label="Amérique">
                  <option value="America/New_York">New York (GMT-5)</option>
                  <option value="America/Chicago">Chicago (GMT-6)</option>
                  <option value="America/Denver">Denver (GMT-7)</option>
                  <option value="America/Los_Angeles">
                    Los Angeles (GMT-8)
                  </option>
                  <option value="America/Toronto">Toronto (GMT-5)</option>
                  <option value="America/Montreal">Montréal (GMT-5)</option>
                  <option value="America/Sao_Paulo">São Paulo (GMT-3)</option>
                  <option value="America/Mexico_City">Mexico (GMT-6)</option>
                </optgroup>
                <optgroup label="Asie">
                  <option value="Asia/Tokyo">Tokyo (GMT+9)</option>
                  <option value="Asia/Shanghai">Shanghai (GMT+8)</option>
                  <option value="Asia/Hong_Kong">Hong Kong (GMT+8)</option>
                  <option value="Asia/Singapore">Singapour (GMT+8)</option>
                  <option value="Asia/Dubai">Dubaï (GMT+4)</option>
                  <option value="Asia/Seoul">Séoul (GMT+9)</option>
                  <option value="Asia/Kolkata">Mumbai (GMT+5:30)</option>
                </optgroup>
                <optgroup label="Océanie">
                  <option value="Australia/Sydney">Sydney (GMT+11)</option>
                  <option value="Australia/Melbourne">
                    Melbourne (GMT+11)
                  </option>
                  <option value="Pacific/Auckland">Auckland (GMT+13)</option>
                </optgroup>
                <optgroup label="Afrique">
                  <option value="Africa/Cairo">Le Caire (GMT+2)</option>
                  <option value="Africa/Johannesburg">
                    Johannesburg (GMT+2)
                  </option>
                  <option value="Africa/Lagos">Lagos (GMT+1)</option>
                  <option value="Africa/Nairobi">Nairobi (GMT+3)</option>
                </optgroup>
              </select>
              <ChevronDown
                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-600 pointer-events-none"
              />
            </div>
            <p class="text-xs text-neutral-600 mt-2 font-medium">
              Utilisé pour afficher vos disponibilités
            </p>
          </div>

          <BaseAlert
            v-if="error"
            variant="error"
            :message="error"
            dismissible
          />

          <BaseAlert
            v-if="success"
            variant="success"
            :message="success"
            dismissible
          />

          <div class="pt-2">
            <BaseButton type="submit" variant="primary" :loading="saving">
              <Save class="w-4 h-4" />
              Enregistrer
            </BaseButton>
          </div>
        </form>
      </section>

      <PasswordChangeForm />

      <section class="bg-white rounded-xl border border-neutral-200 p-6 sm:p-7">
        <h2 class="text-lg font-semibold text-neutral-900 mb-5">Abonnement</h2>

        <div v-if="subscriptionStore.loading" class="space-y-5 animate-pulse">
          <div
            class="p-5 bg-neutral-50 rounded-xl border border-neutral-300 space-y-3"
          >
            <div class="h-4 bg-neutral-200 rounded w-28"></div>
            <div class="h-5 bg-neutral-200 rounded w-36"></div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div
              class="p-5 bg-neutral-50 rounded-xl border border-neutral-300 space-y-2"
            >
              <div class="h-3 bg-neutral-200 rounded w-14"></div>
              <div class="h-5 bg-neutral-200 rounded w-20"></div>
            </div>
            <div
              class="p-5 bg-neutral-50 rounded-xl border border-neutral-300 space-y-2"
            >
              <div class="h-3 bg-neutral-200 rounded w-12"></div>
              <div class="h-5 bg-neutral-200 rounded w-24"></div>
            </div>
          </div>
          <div class="h-10 bg-neutral-200 rounded-lg w-40"></div>
        </div>

        <div v-else class="space-y-5">
          <div
            class="flex items-center justify-between p-5 bg-neutral-50 border border-neutral-300 rounded-xl"
          >
            <div>
              <p class="text-sm font-medium text-neutral-700">Plan actuel</p>
              <p class="text-sm text-neutral-600 mt-1">
                {{
                  subscriptionStore.isPro ? "Abonnement Pro" : "Plan Gratuit"
                }}
              </p>
            </div>
            <div
              v-if="subscriptionStore.isPro"
              class="px-4 py-2 bg-brand-500 text-white text-sm font-medium rounded-full"
            >
              Pro
            </div>
            <div
              v-else
              class="px-4 py-2 bg-neutral-200 text-neutral-700 text-sm font-medium rounded-full border border-neutral-400"
            >
              Gratuit
            </div>
          </div>

          <div v-if="subscriptionStore.isPro" class="space-y-4">
            <div class="grid grid-cols-2 gap-3 text-sm">
              <div
                class="p-5 bg-neutral-50 rounded-xl border border-neutral-300"
              >
                <p class="text-neutral-600 text-xs mb-1">Statut</p>
                <p v-if="isOnGracePeriod" class="font-medium text-warning-700">
                  Annulé
                </p>
                <p v-else class="font-medium text-success-700">Actif</p>
              </div>
              <div
                class="p-5 bg-neutral-50 rounded-xl border border-neutral-300"
              >
                <p class="text-neutral-600 text-xs mb-1">Tarif</p>
                <p class="font-medium text-neutral-900">9€/mois</p>
              </div>
              <div
                v-if="isOnGracePeriod"
                class="col-span-2 p-3 bg-warning-100 rounded-lg border border-warning-300"
              >
                <p class="text-xs text-warning-800">
                  Accès jusqu'au <strong>{{ endsAt }}</strong>
                </p>
              </div>
            </div>

            <div v-if="isOnGracePeriod" class="space-y-2">
              <BaseButton
                @click="handleResumeSubscription"
                :loading="resuming"
                variant="primary"
              >
                <Check class="w-4 h-4" />
                Réactiver l'abonnement
              </BaseButton>
            </div>
            <div v-else class="space-y-2">
              <BaseButton
                @click="handleCancelSubscription"
                :loading="cancelling"
                variant="secondary"
              >
                Annuler l'abonnement
              </BaseButton>
            </div>

            <div class="pt-5 border-t border-neutral-300">
              <div class="flex items-center gap-2 mb-4">
                <CreditCard class="w-4 h-4 text-neutral-600" />
                <p class="text-sm font-semibold text-neutral-900">
                  Facturation
                </p>
              </div>
              <BaseButton
                @click="handleOpenBillingPortal"
                :loading="openingPortal"
                variant="secondary"
              >
                <CreditCard class="w-4 h-4" />
                Gérer la facturation
              </BaseButton>
              <p class="text-xs text-neutral-600 mt-3 flex items-center gap-1">
                <Shield class="w-3.5 h-3.5" />
                Sécurisé par Stripe
              </p>
            </div>
          </div>

          <div v-else class="space-y-4">
            <div class="p-5 bg-neutral-50 rounded-lg border border-neutral-300">
              <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-neutral-700"
                  >Utilisation ce mois</span
                >
                <span class="text-sm font-bold text-neutral-900"
                  >{{ subscriptionStore.used }}/{{
                    subscriptionStore.limit
                  }}</span
                >
              </div>
              <div class="h-2 bg-neutral-200 rounded-full overflow-hidden">
                <div
                  :class="progressColor"
                  class="h-full transition-all duration-300 rounded-full"
                  :style="{ width: `${subscriptionStore.percentage}%` }"
                ></div>
              </div>
              <p class="text-xs text-neutral-600 mt-2">
                {{ subscriptionStore.percentage }}% de votre limite mensuelle
                utilisée
              </p>
            </div>

            <BaseButton
              @click="showUpgradeModal = true"
              variant="primary"
              class="w-full sm:w-auto"
            >
              <ArrowUp class="w-4 h-4" />
              Passer à Pro
            </BaseButton>
          </div>
        </div>
      </section>

      <section class="bg-white rounded-xl border border-neutral-200 p-6 sm:p-7">
        <h2 class="text-lg font-semibold text-neutral-900 mb-5">Compte</h2>

        <BaseButton
          @click="handleLogout"
          variant="secondary"
          class="w-full sm:w-auto"
        >
          <LogOut class="w-4 h-4" />
          Se déconnecter
        </BaseButton>
      </section>
    </div>

    <UpgradeModal :show="showUpgradeModal" @close="showUpgradeModal = false" />
  </DashboardLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useProfileStore } from "@/stores/profile";
import { useSubscriptionStore } from "@/stores/subscription";
import { useToastStore } from "@/stores/toast";
import { logError } from "@/utils/logger";
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import PasswordChangeForm from "@/components/forms/PasswordChangeForm.vue";
import UpgradeModal from "@/components/subscription/UpgradeModal.vue";
import {
  User,
  Mail,
  BriefcaseBusiness,
  Save,
  ArrowUp,
  Check,
  CreditCard,
  Shield,
  Building2,
  Clock,
  ChevronDown,
  LogOut,
} from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const profileStore = useProfileStore();
const subscriptionStore = useSubscriptionStore();
const toastStore = useToastStore();

const formData = ref({
  firstname: "",
  lastname: "",
  email: "",
  business_name: "",
  activity: "",
  timezone: "",
});

const saving = computed(() => profileStore.saving);
const error = computed(() => profileStore.error);
const success = computed(() => profileStore.success);
const showUpgradeModal = ref(false);
const cancelling = computed(() => subscriptionStore.saving);
const resuming = computed(() => subscriptionStore.saving);
const openingPortal = ref(false);

const progressColor = computed(() => {
  const pct = subscriptionStore.percentage;
  if (pct >= 90) return "bg-error-500";
  if (pct >= 70) return "bg-warning-500";
  return "bg-brand-500";
});

const isOnGracePeriod = computed(() => {
  return subscriptionStore.subscription?.on_grace_period ?? false;
});

const endsAt = computed(() => {
  if (!subscriptionStore.subscription?.ends_at) return null;
  const date = new Date(subscriptionStore.subscription.ends_at);
  return date.toLocaleDateString("fr-FR", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
});

async function updateProfile() {
  try {
    await profileStore.update(formData.value);
    await authStore.fetchUser();
  } catch (err) {}
}

const handleCancelSubscription = async () => {
  if (
    !confirm(
      "Êtes-vous sûr de vouloir annuler votre abonnement Pro ? Vous conserverez l'accès jusqu'à la fin de votre période de facturation."
    )
  ) {
    return;
  }

  try {
    await subscriptionStore.cancelSubscription();
  } catch (error) {
    logError("ProfileView.handleCancelSubscription", error);
  }
};

const handleResumeSubscription = async () => {
  try {
    await subscriptionStore.resumeSubscription();
  } catch (error) {
    logError("ProfileView.handleResumeSubscription", error);
  }
};

const handleOpenBillingPortal = async () => {
  openingPortal.value = true;
  try {
    await subscriptionStore.openBillingPortal();
  } catch (error) {
    openingPortal.value = false;

    const errorMessage =
      error.response?.data?.message ||
      error.message ||
      "Impossible d'ouvrir le portail de gestion";

    if (
      errorMessage.includes("configuration") ||
      errorMessage.includes("portal")
    ) {
      toastStore.error("Le portail de facturation n'est pas encore configuré.");
    } else {
      toastStore.error(errorMessage);
    }

    logError("ProfileView.handleOpenBillingPortal", error);
  }
};

const handleLogout = async () => {
  await authStore.logout();
  router.push("/login");
};

onMounted(async () => {
  if (authStore.user) {
    formData.value = {
      firstname: authStore.user.firstname || "",
      lastname: authStore.user.lastname || "",
      email: authStore.user.email || "",
      business_name: authStore.user.business_name || "",
      activity: authStore.user.activity || "",
      timezone: authStore.user.timezone || "Europe/Paris",
    };
  }

  await subscriptionStore.fetchStatus();
});
</script>
