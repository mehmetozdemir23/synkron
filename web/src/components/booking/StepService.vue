<template>
  <div>
    <div class="grid grid-cols-1 gap-2.5">
      <button
        v-for="service in services"
        :key="service.id"
        @click="selectService(service)"
        :class="[
          'text-left p-4 sm:p-5 rounded-xl border-2 transition-all group relative overflow-hidden',
          selectedService?.id === service.id
            ? 'border-brand-600 bg-gradient-to-br from-brand-50 to-brand-100/50 shadow-md'
            : 'border-neutral-200 bg-white hover:border-brand-400 hover:shadow-sm',
        ]"
      >
        <div class="flex items-start justify-between gap-3 mb-3">
          <div class="flex-1 min-w-0">
            <h3 :class="[
              'font-semibold text-base leading-tight',
              selectedService?.id === service.id ? 'text-brand-700' : 'text-neutral-900'
            ]">
              {{ service.name }}
            </h3>
            <p
              v-if="service.description"
              class="text-sm text-neutral-600 line-clamp-1 mt-1"
            >
              {{ service.description }}
            </p>
          </div>
          <div
            :class="[
              'w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 transition-all',
              selectedService?.id === service.id
                ? 'bg-brand-600 shadow-md'
                : 'bg-neutral-100 border-2 border-neutral-300',
            ]"
          >
            <svg v-if="selectedService?.id === service.id" class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <div :class="[
          'flex items-center gap-3 text-sm font-medium',
          selectedService?.id === service.id ? 'text-brand-700' : 'text-neutral-600'
        ]">
          <div class="flex items-center gap-1.5">
            <Clock class="w-4 h-4" />
            <span>{{ service.duration_minutes }} min</span>
          </div>
          <div class="w-1 h-1 rounded-full bg-current opacity-40"></div>
          <div class="flex items-center gap-1.5">
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
