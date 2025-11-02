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
      <section
        class="bg-neutral-200 rounded-xl border border-neutral-400 p-6 sm:p-7 transition-all hover:shadow-md"
      >
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
            <label class="block text-sm font-semibold text-neutral-800 mb-2"
              >Adresse email</label
            >
            <div
              class="flex items-center gap-3 px-4 py-3 bg-neutral-100 border border-neutral-300 rounded-xl"
            >
              <Mail class="w-5 h-5 text-neutral-600" />
              <span class="text-sm font-medium text-neutral-800">{{
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
            :icon-component="Briefcase"
          />

          <BaseAlert
            v-if="error"
            variant="error"
            :message="error"
            dismissible
            @update:modelValue="error = ''"
          />

          <BaseAlert
            v-if="success"
            variant="success"
            :message="success"
            dismissible
            @update:modelValue="success = ''"
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

      <section
        class="bg-neutral-200 rounded-xl border border-neutral-400 p-6 sm:p-7 transition-all hover:shadow-md"
      >
        <h2 class="text-lg font-semibold text-neutral-900 mb-5">Abonnement</h2>

        <div v-if="subscriptionStore.loading" class="space-y-5 animate-pulse">
          <div
            class="p-5 bg-neutral-100 rounded-xl border border-neutral-300 space-y-3"
          >
            <div class="h-4 bg-neutral-300 rounded w-28"></div>
            <div class="h-5 bg-neutral-300 rounded w-36"></div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div
              class="p-5 bg-neutral-100 rounded-xl border border-neutral-300 space-y-2"
            >
              <div class="h-3 bg-neutral-300 rounded w-14"></div>
              <div class="h-5 bg-neutral-300 rounded w-20"></div>
            </div>
            <div
              class="p-5 bg-neutral-100 rounded-xl border border-neutral-300 space-y-2"
            >
              <div class="h-3 bg-neutral-300 rounded w-12"></div>
              <div class="h-5 bg-neutral-300 rounded w-24"></div>
            </div>
          </div>
          <div class="h-10 bg-neutral-300 rounded-lg w-40"></div>
        </div>

        <div v-else class="space-y-5">
          <div
            class="flex items-center justify-between p-5 bg-neutral-100 border border-neutral-300 rounded-xl"
          >
            <div>
              <p class="text-sm font-medium text-neutral-800">Plan actuel</p>
              <p class="text-sm text-neutral-700 mt-1">
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
              class="px-4 py-2 bg-neutral-300 text-neutral-800 text-sm font-medium rounded-full border border-neutral-400"
            >
              Gratuit
            </div>
          </div>

          <div v-if="subscriptionStore.isPro" class="space-y-4">
            <div class="grid grid-cols-2 gap-3 text-sm">
              <div
                class="p-5 bg-neutral-100 rounded-xl border border-neutral-300"
              >
                <p class="text-neutral-700 text-xs mb-1">Statut</p>
                <p v-if="isOnGracePeriod" class="font-medium text-warning-700">
                  Annulé
                </p>
                <p v-else class="font-medium text-success-700">Actif</p>
              </div>
              <div
                class="p-5 bg-neutral-100 rounded-xl border border-neutral-300"
              >
                <p class="text-neutral-700 text-xs mb-1">Tarif</p>
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
                <CreditCard class="w-4 h-4 text-neutral-700" />
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
            <div
              class="p-5 bg-neutral-100 rounded-lg border border-neutral-300"
            >
              <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-neutral-800"
                  >Utilisation ce mois</span
                >
                <span class="text-sm font-bold text-neutral-900"
                  >{{ subscriptionStore.used }}/{{
                    subscriptionStore.limit
                  }}</span
                >
              </div>
              <div class="h-2 bg-neutral-300 rounded-full overflow-hidden">
                <div
                  :class="progressColor"
                  class="h-full transition-all duration-300 rounded-full"
                  :style="{ width: `${subscriptionStore.percentage}%` }"
                ></div>
              </div>
              <p class="text-xs text-neutral-700 mt-2">
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
    </div>

    <UpgradeModal :show="showUpgradeModal" @close="showUpgradeModal = false" />
  </DashboardLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useSubscriptionStore } from "@/stores/subscription";
import { useToastStore } from "@/stores/toast";
import { profileAPI } from "@/services/api";
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import PasswordChangeForm from "@/components/forms/PasswordChangeForm.vue";
import UpgradeModal from "@/components/subscription/UpgradeModal.vue";
import {
  User,
  Mail,
  Briefcase,
  Save,
  ArrowUp,
  Check,
  CreditCard,
  Shield,
  Building2,
} from "lucide-vue-next";

const authStore = useAuthStore();
const subscriptionStore = useSubscriptionStore();
const toastStore = useToastStore();

const formData = ref({
  firstname: "",
  lastname: "",
  email: "",
  business_name: "",
  activity: "",
});

const saving = ref(false);
const error = ref("");
const success = ref("");
const showUpgradeModal = ref(false);
const cancelling = ref(false);
const resuming = ref(false);
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
  saving.value = true;
  error.value = "";
  success.value = "";

  try {
    await profileAPI.update(formData.value);
    await authStore.fetchUser();
    success.value = "Profil mis à jour avec succès !";
    setTimeout(() => (success.value = ""), 3000);
  } catch (err) {
    error.value =
      err.response?.data?.message || "Erreur lors de la mise à jour";
  } finally {
    saving.value = false;
  }
}

const handleCancelSubscription = async () => {
  if (
    !confirm(
      "Êtes-vous sûr de vouloir annuler votre abonnement Pro ? Vous conserverez l'accès jusqu'à la fin de votre période de facturation."
    )
  ) {
    return;
  }

  cancelling.value = true;
  try {
    await subscriptionStore.cancelSubscription();
    toastStore.success(
      "Abonnement annulé. Vous conservez l'accès jusqu'au " + endsAt.value
    );
  } catch (error) {
    toastStore.error("Erreur lors de l'annulation de l'abonnement");
    console.error("Error cancelling subscription:", error);
  } finally {
    cancelling.value = false;
  }
};

const handleResumeSubscription = async () => {
  resuming.value = true;
  try {
    await subscriptionStore.resumeSubscription();
    toastStore.success("Abonnement réactivé avec succès!");
  } catch (error) {
    toastStore.error("Erreur lors de la réactivation de l'abonnement");
    console.error("Error resuming subscription:", error);
  } finally {
    resuming.value = false;
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

    console.error("Error opening billing portal:", error);
  }
};

onMounted(async () => {
  if (authStore.user) {
    formData.value = {
      firstname: authStore.user.firstname || "",
      lastname: authStore.user.lastname || "",
      email: authStore.user.email || "",
      business_name: authStore.user.business_name || "",
      activity: authStore.user.activity || "",
    };
  }

  await subscriptionStore.fetchStatus();
});
</script>
