<template>
  <div class="space-y-4 sm:space-y-6">
    <div>
      <h2 class="text-xl sm:text-2xl font-normal text-neutral-950 mb-1 sm:mb-2">Choisissez un service</h2>
      <p class="text-xs sm:text-sm text-neutral-700">Sélectionnez le service que vous souhaitez réserver</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
      <button
        v-for="service in services"
        :key="service.id"
        @click="selectService(service)"
        :class="[
          'text-left p-3 sm:p-4 rounded-lg border-2 transition-all group',
          selectedService?.id === service.id
            ? 'border-brand-500 bg-brand-500/5'
            : 'border-neutral-400 bg-neutral-300 hover:border-brand-500/50 hover:bg-neutral-300/50',
        ]"
      >
        <div class="flex items-start justify-between gap-2 sm:gap-3 mb-2 sm:mb-3">
          <div class="flex-1 min-w-0">
            <h3 class="font-medium text-neutral-950 text-sm sm:text-base mb-0.5 sm:mb-1">
              {{ service.name }}
            </h3>
            <p
              v-if="service.description"
              class="text-xs sm:text-sm text-neutral-700 line-clamp-2"
            >
              {{ service.description }}
            </p>
          </div>
          <div
            :class="[
              'w-4 h-4 sm:w-5 sm:h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all',
              selectedService?.id === service.id
                ? 'border-brand-500 bg-brand-500'
                : 'border-neutral-500 bg-transparent group-hover:border-brand-500',
            ]"
          >
            <svg v-if="selectedService?.id === service.id" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-neutral-700">
          <div class="flex items-center gap-1 sm:gap-1.5">
            <Clock class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-neutral-600" />
            <span>{{ service.duration_minutes }} min</span>
          </div>
          <div class="w-1 h-1 rounded-full bg-neutral-500"></div>
          <div class="flex items-center gap-1 sm:gap-1.5">
            <DollarSign class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-neutral-600" />
            <span>{{ service.price ? `${service.price}€` : "Gratuit" }}</span>
          </div>
        </div>
      </button>
    </div>
  </div>
</template>

<script setup>
import { Clock, DollarSign } from "lucide-vue-next";

const props = defineProps({
  services: {
    type: Array,
    required: true,
  },
  selectedService: {
    type: Object,
    default: null,
  },
});

const emit = defineEmits(["select-service"]);

function selectService(service) {
  emit("select-service", service);
}
</script>
