<template>
  <div>
    <div class="grid grid-cols-1 gap-2.5">
      <button
        v-for="service in services"
        :key="service.id"
        @click="selectService(service)"
        :class="[
          'text-left p-3.5 sm:p-4 rounded-xl border-2 transition-all group relative overflow-hidden',
          selectedService?.id === service.id
            ? 'border-neutral-400 bg-neutral-200/50 shadow-sm'
            : 'border-neutral-200 bg-neutral-100/50 hover:border-neutral-300 hover:shadow-sm',
        ]"
      >
        <div class="flex items-start justify-between gap-2.5 mb-2.5">
          <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-neutral-950 text-base leading-tight">
              {{ service.name }}
            </h3>
            <p
              v-if="service.description"
              class="text-sm text-neutral-800 line-clamp-1 mt-0.5"
            >
              {{ service.description }}
            </p>
          </div>
          <div
            :class="[
              'w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 transition-all',
              selectedService?.id === service.id
                ? 'bg-neutral-500 shadow-sm'
                : 'bg-neutral-200 border-2 border-neutral-300',
            ]"
          >
            <svg v-if="selectedService?.id === service.id" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <div class="flex items-center gap-3 text-sm text-neutral-800 font-medium">
          <div class="flex items-center gap-1">
            <Clock class="w-4 h-4" />
            <span>{{ service.duration_minutes }} min</span>
          </div>
          <div class="w-1 h-1 rounded-full bg-neutral-600"></div>
          <div class="flex items-center gap-1">
            <DollarSign class="w-4 h-4" />
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
