<template>
  <DashboardLayout>
    <template #header>
      <div
        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4"
      >
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-normal text-neutral-900">Disponibilités</h1>
          <p class="text-xs sm:text-sm text-neutral-600 mt-1">
            Définissez vos horaires de travail pour chaque jour de la semaine
          </p>
        </div>
        <div class="hidden sm:block flex-shrink-0">
          <BaseButton
            @click="saveAvailabilities"
            variant="primary"
            :loading="saving"
            :disabled="loading || !hasChanges"
          >
            <Save class="w-4 h-4" />
            Enregistrer
          </BaseButton>
        </div>
      </div>
    </template>

    <div class="w-full space-y-6">
      <div
        class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 bg-brand-50 border border-brand-200 rounded-xl"
      >
        <div
          class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-brand-100 self-start sm:self-auto flex items-center justify-center flex-shrink-0"
        >
          <Info class="w-4 h-4 text-brand-600" />
        </div>
        <p class="text-xs sm:text-sm text-neutral-700 leading-relaxed">
          Les créneaux de réservation seront calculés automatiquement en
          fonction de vos disponibilités et de la durée de vos services.
        </p>
      </div>

      <form @submit.prevent="saveAvailabilities" class="space-y-6">
        <div v-if="loading" class="space-y-6">
          <div
            v-for="i in 7"
            :key="i"
            class="bg-white rounded-xl border border-neutral-200 p-6 animate-pulse"
          >
            <div class="h-5 bg-neutral-200 rounded w-24 mb-4"></div>
            <div class="space-y-3">
              <div class="flex items-center gap-2">
                <div class="h-10 bg-neutral-200 rounded-lg flex-1"></div>
                <div class="h-5 w-8 bg-neutral-200 rounded"></div>
                <div class="h-10 bg-neutral-200 rounded-lg flex-1"></div>
                <div class="h-10 w-10 bg-neutral-200 rounded-lg"></div>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="space-y-6">
          <div
            v-for="day in days"
            :key="day.value"
            class="bg-white rounded-xl border border-neutral-200 p-4 sm:p-6 transition-all hover:shadow-lg"
          >
            <div
              class="flex items-center justify-between gap-2 xs:gap-0 mb-4 sm:mb-5"
            >
              <h3 class="text-sm sm:text-base font-semibold text-neutral-900">
                {{ day.label }}
              </h3>
              <span
                v-if="day.slots.length > 0"
                class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-brand-100 text-brand-700 text-xs font-medium rounded-full"
              >
                {{ day.slots.length }} plage{{
                  day.slots.length > 1 ? "s" : ""
                }}
              </span>
            </div>

            <div
              v-if="day.slots.length === 0"
              class="text-sm text-neutral-600 mb-4 italic"
            >
              Aucune disponibilité configurée pour ce jour
            </div>

            <div v-else class="space-y-3 mb-4">
              <div
                v-for="(slot, index) in day.slots"
                :key="index"
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2"
              >
                <div class="flex items-center gap-2 flex-1">
                  <div class="relative flex-1">
                    <Clock
                      class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-600 pointer-events-none"
                    />
                    <input
                      v-model="slot.start_time"
                      type="time"
                      required
                      class="input pl-10 text-sm min-h-[44px]"
                    />
                  </div>
                  <span
                    class="text-sm text-neutral-600 font-medium px-1 flex-shrink-0"
                    >→</span
                  >
                  <div class="relative flex-1">
                    <Clock
                      class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-600 pointer-events-none"
                    />
                    <input
                      v-model="slot.end_time"
                      type="time"
                      required
                      class="input pl-10 text-sm min-h-[44px]"
                    />
                  </div>
                </div>
                <button
                  type="button"
                  @click="removeSlot(day, index)"
                  class="min-w-[44px] min-h-[44px] w-full sm:w-10 h-10 sm:h-10 flex items-center justify-center text-error-600 hover:bg-error-50 active:bg-error-100 rounded-lg transition-colors flex-shrink-0"
                  title="Supprimer"
                >
                  <Trash2 class="w-4 h-4" />
                  <span class="sm:hidden ml-2 text-sm font-medium"
                    >Supprimer</span
                  >
                </button>
              </div>
            </div>

            <button
              type="button"
              @click="addSlot(day)"
              class="flex items-center gap-2 px-4 py-2.5 min-h-[44px] text-xs sm:text-sm font-medium text-brand-600 hover:bg-brand-50 active:bg-brand-100 border-2 border-neutral-300 border-dashed rounded-lg transition-colors w-full justify-center"
            >
              <Plus class="w-4 h-4" />
              Ajouter une plage horaire
            </button>
          </div>
        </div>

        <BaseAlert v-if="error" variant="error" :message="error" dismissible />

        <BaseAlert
          v-if="success"
          variant="success"
          :message="success"
          dismissible
        />
      </form>
    </div>

    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      leave-active-class="transition-all duration-200 ease-in"
      enter-from-class="opacity-0 translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-4"
    >
      <div
        v-if="hasChanges"
        class="sm:hidden fixed bottom-20 left-0 right-0 z-40 px-4 pb-3"
        style="padding-bottom: calc(0.75rem + env(safe-area-inset-bottom))"
      >
        <button
          @click="saveAvailabilities"
          :disabled="loading || saving"
          class="w-full flex items-center justify-center gap-2.5 px-5 py-3.5 bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white rounded-xl font-medium text-[15px] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-[0_4px_16px_rgba(0,0,0,0.12)] active:scale-[0.98] border border-brand-700/20"
        >
          <Save class="w-5 h-5" :class="{ 'animate-spin': saving }" />
          <span>{{ saving ? "Enregistrement..." : "Enregistrer" }}</span>
        </button>
      </div>
    </Transition>
  </DashboardLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useAvailabilitiesStore } from "@/stores/availabilities";
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import BaseAlert from "@/components/ui/BaseAlert.vue";
import { Info, Clock, Plus, Trash2, Save } from "lucide-vue-next";

const availabilitiesStore = useAvailabilitiesStore();

const days = computed(() => availabilitiesStore.groupedByDay);
const loading = computed(() => availabilitiesStore.loading);
const saving = computed(() => availabilitiesStore.saving);
const error = computed(() => availabilitiesStore.error);
const success = computed(() => availabilitiesStore.success);
const hasChanges = ref(false);
const initialData = ref(null);

watch(
  days,
  (newDays) => {
    if (!initialData.value || loading.value) return;

    const currentData = JSON.stringify(newDays);
    hasChanges.value = currentData !== initialData.value;
  },
  { deep: true }
);

function addSlot(day) {
  day.slots.push({ start_time: "09:00", end_time: "17:00" });
}

function removeSlot(day, index) {
  day.slots.splice(index, 1);
}

async function saveAvailabilities() {
  const availabilities = [];
  days.value.forEach((day) => {
    day.slots.forEach((slot) => {
      availabilities.push({
        day_of_week: day.value,
        start_time: slot.start_time,
        end_time: slot.end_time,
      });
    });
  });

  try {
    await availabilitiesStore.upsert({ availabilities });
    initialData.value = JSON.stringify(days.value);
    hasChanges.value = false;
  } catch (err) {}
}

onMounted(async () => {
  await availabilitiesStore.fetchAll();
  initialData.value = JSON.stringify(days.value);
});
</script>
