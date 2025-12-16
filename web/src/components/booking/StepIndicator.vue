<template>
  <div class="flex items-start justify-center gap-1 sm:gap-2 md:gap-4">
    <div
      v-for="(stepLabel, index) in ['Service', 'Date', 'Informations']"
      :key="index + 1"
      class="flex items-start"
    >
      <div class="flex flex-col items-center gap-1.5 sm:gap-2">
        <div
          :class="[
            'w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center text-xs sm:text-sm md:text-base font-semibold transition-all duration-300',
            currentStep > index + 1
              ? 'bg-brand-500 text-white shadow-sm'
              : currentStep === index + 1
              ? 'bg-brand-500 text-white ring-2 sm:ring-4 ring-brand-500/20 shadow-lg'
              : 'bg-neutral-200 text-neutral-500',
          ]"
        >
          <CheckCircle
            v-if="currentStep > index + 1"
            class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6"
          />
          <span v-else>{{ index + 1 }}</span>
        </div>

        <span
          :class="[
            'text-[10px] sm:text-xs md:text-sm font-medium transition-colors text-center whitespace-nowrap',
            currentStep >= index + 1 ? 'text-neutral-900' : 'text-neutral-500',
          ]"
        >
          {{ stepLabel }}
        </span>
      </div>

      <div
        v-if="index < 2"
        class="flex items-center h-8 sm:h-10 md:h-12"
      >
        <div
          :class="[
            'h-0.5 w-16 sm:w-28 md:w-36 mx-2 sm:mx-3 md:mx-4 transition-all duration-300 rounded-full',
            currentStep > index + 1 ? 'bg-brand-500' : 'bg-neutral-200',
          ]"
        ></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { CheckCircle } from "lucide-vue-next";

defineProps({
  currentStep: {
    type: Number,
    required: true,
  },
});
</script>
