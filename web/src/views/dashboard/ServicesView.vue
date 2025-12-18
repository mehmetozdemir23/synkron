<template>
  <DashboardLayout>
    <template #header>
      <div
        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4"
      >
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-normal text-neutral-900">Services</h1>
          <p class="text-sm text-neutral-600 mt-1">
            Créez et gérez vos services pour accepter les réservations
          </p>
        </div>
        <div class="flex-shrink-0">
          <BaseButton
            @click="showModal = true"
            variant="primary"
            class="w-full sm:w-auto"
          >
            <Plus class="w-4 h-4" />
            Nouveau service
          </BaseButton>
        </div>
      </div>
    </template>

    <div class="w-full">
      <div
        v-if="loading"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
      >
        <div
          v-for="i in 3"
          :key="i"
          class="bg-neutral-200 rounded-xl border border-neutral-400 p-5 space-y-4"
        >
          <div class="flex items-start justify-between mb-4">
            <div class="flex-1 space-y-3">
              <div class="h-5 bg-neutral-300 rounded w-3/4 animate-pulse"></div>
              <div
                class="h-6 bg-neutral-300 rounded-full w-16 animate-pulse"
              ></div>
            </div>
            <div
              class="w-2 h-2 bg-neutral-300 rounded-full animate-pulse"
            ></div>
          </div>
          <div class="space-y-3">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-neutral-300 rounded-full animate-pulse"
              ></div>
              <div class="flex-1 space-y-2">
                <div
                  class="h-3 bg-neutral-300 rounded w-12 animate-pulse"
                ></div>
                <div
                  class="h-4 bg-neutral-300 rounded w-16 animate-pulse"
                ></div>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-neutral-300 rounded-full animate-pulse"
              ></div>
              <div class="flex-1 space-y-2">
                <div
                  class="h-3 bg-neutral-300 rounded w-12 animate-pulse"
                ></div>
                <div
                  class="h-4 bg-neutral-300 rounded w-16 animate-pulse"
                ></div>
              </div>
            </div>
          </div>
          <div class="flex items-center gap-2 pt-3 border-t border-neutral-300">
            <div
              class="flex-1 h-10 bg-neutral-300 rounded-lg animate-pulse"
            ></div>
            <div
              class="w-10 h-10 bg-neutral-300 rounded-lg animate-pulse"
            ></div>
          </div>
        </div>
      </div>

      <EmptyState
        v-else-if="services.length === 0"
        :icon="Briefcase"
        title="Aucun service"
        description="Commencez par créer votre premier service pour accepter les réservations"
      >
        <template #action>
          <BaseButton @click="showModal = true" variant="primary" class="px-6">
            <Plus class="w-5 h-5" />
            Créer mon premier service
          </BaseButton>
        </template>
      </EmptyState>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="service in services"
          :key="service.id"
          class="group relative bg-neutral-200 rounded-xl border border-neutral-400 p-5 overflow-hidden"
        >
          <div class="flex items-start justify-between mb-4">
            <div class="flex-1 pr-2">
              <h3 class="text-base font-medium text-neutral-900 mb-2">
                {{ service.name }}
              </h3>
              <span
                :class="[
                  'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border',
                  service.is_active
                    ? 'bg-success-100 text-success-700 border-success-200'
                    : 'bg-warning-100 text-warning-700 border-warning-200',
                ]"
              >
                {{ service.is_active ? "Actif" : "Inactif" }}
              </span>
            </div>

            <div
              :class="[
                'w-2 h-2 rounded-full flex-shrink-0',
                service.is_active ? 'bg-success-500' : 'bg-neutral-600',
              ]"
            ></div>
          </div>

          <div class="mb-4 space-y-3">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center"
              >
                <Clock class="w-4 h-4 text-brand-700" />
              </div>
              <div>
                <div class="text-xs text-neutral-700">Durée</div>
                <div class="text-sm font-medium text-neutral-900">
                  {{ service.duration_minutes }} min
                </div>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 rounded-full bg-neutral-300 flex items-center justify-center"
              >
                <DollarSign class="w-4 h-4 text-neutral-800" />
              </div>
              <div>
                <div class="text-xs text-neutral-700">Prix</div>
                <div class="text-sm font-medium text-neutral-900">
                  {{ service.price ? `${service.price}€` : "Gratuit" }}
                </div>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-2 pt-3 border-t border-neutral-300">
            <button
              @click="editService(service)"
              class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 text-sm font-medium text-brand-600 hover:bg-brand-50 active:bg-brand-100 rounded-lg transition-colors"
            >
              <Edit2 class="w-4 h-4" />
              Modifier
            </button>
            <button
              @click="deleteServiceConfirm(service)"
              class="flex items-center justify-center w-10 h-10 text-error-600 hover:bg-error-50 active:bg-error-100 rounded-lg transition-colors"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>

      <BaseModal :show="showModal" :processing="saving" @close="closeModal">
        <template #header>
          {{ editingService ? "Modifier le service" : "Nouveau service" }}
        </template>

        <p class="text-sm text-neutral-700 mb-6">
          {{
            editingService
              ? "Mettez à jour les informations de ce service"
              : "Créez un nouveau service pour vos clients"
          }}
        </p>

        <form class="space-y-5">
          <BaseInput
            v-model="formData.name"
            label="Nom du service"
            placeholder="Ex: Consultation"
            required
          />
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
            <BaseInput
              v-model.number="formData.duration_minutes"
              type="number"
              label="Durée (min)"
              placeholder="60"
              min="1"
              required
            />
            <BaseInput
              v-model.number="formData.price"
              type="number"
              label="Prix (€)"
              placeholder="0"
              step="0.01"
              min="0"
            />
          </div>

          <label class="flex items-center gap-2 cursor-pointer">
            <input
              v-model="formData.is_active"
              type="checkbox"
              class="w-4 h-4 text-brand-600 rounded border-neutral-400 focus:ring-2 focus:ring-brand-500/20"
            />
            <span class="text-sm font-medium text-neutral-800"
              >Service actif</span
            >
          </label>

          <BaseAlert
            v-if="error"
            variant="error"
            :message="error"
            dismissible
            @update:modelValue="error = ''"
          />
        </form>

        <template #footer>
          <div class="flex items-center gap-3">
            <BaseButton
              type="button"
              @click="closeModal"
              variant="secondary"
              class="flex-1"
            >
              Annuler
            </BaseButton>
            <BaseButton
              type="button"
              variant="primary"
              :loading="saving"
              class="flex-1"
              @click="saveService"
            >
              Enregistrer
            </BaseButton>
          </div>
        </template>
      </BaseModal>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useServicesStore } from "@/stores/services";
import { useAlertStore } from "@/stores/alert";
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseModal from "@/components/ui/BaseModal.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import EmptyState from "@/components/ui/EmptyState.vue";
import {
  Plus,
  Briefcase,
  Clock,
  Edit2,
  Trash2,
  DollarSign,
} from "lucide-vue-next";

const servicesStore = useServicesStore();
const alertStore = useAlertStore();

const showModal = ref(false);
const editingService = ref(null);
const formData = ref({
  name: "",
  duration_minutes: 60,
  price: null,
  is_active: true,
});
const saving = ref(false);
const error = ref("");

const services = computed(() => servicesStore.services);
const loading = computed(() => servicesStore.loading);

function editService(service) {
  editingService.value = service;
  formData.value = {
    name: service.name,
    duration_minutes: service.duration_minutes,
    price: service.price,
    is_active: service.is_active,
  };
  showModal.value = true;
}

async function saveService() {
  saving.value = true;
  error.value = "";
  try {
    if (editingService.value) {
      await servicesStore.update(editingService.value.id, formData.value);
    } else {
      await servicesStore.create(formData.value);
    }
    closeModal();
  } catch (err) {
    error.value =
      err.response?.data?.message || "Erreur lors de l'enregistrement";
  } finally {
    saving.value = false;
  }
}

async function deleteServiceConfirm(service) {
  if (confirm(`Supprimer le service "${service.name}" ?`)) {
    try {
      await servicesStore.remove(service.id);
    } catch (err) {
      await alertStore.error("Erreur lors de la suppression");
    }
  }
}

function closeModal() {
  showModal.value = false;
  editingService.value = null;
  formData.value = {
    name: "",
    duration_minutes: 60,
    price: null,
    is_active: true,
  };
  error.value = "";
}

onMounted(async () => {
  await servicesStore.fetchAll({ force: false });
});
</script>
