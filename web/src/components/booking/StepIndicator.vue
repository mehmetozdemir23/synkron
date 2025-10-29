<template>
  <div class="flex items-center justify-center gap-1 sm:gap-2 md:gap-4">
    <div
      v-for="(stepLabel, index) in ['Service', 'Date', 'Informations']"
      :key="index + 1"
      class="flex items-center"
    >
      <div class="flex flex-col items-center gap-1 sm:gap-2">
        <div
          :class="[
            'w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-semibold transition-all',
            currentStep > index + 1
              ? 'bg-brand-500 text-white'
              : currentStep === index + 1
              ? 'bg-brand-500 text-white ring-2 sm:ring-4 ring-brand-500/20'
              : 'bg-neutral-300 text-neutral-600 border-2 border-neutral-400',
          ]"
        >
          <CheckCircle
            v-if="currentStep > index + 1"
            class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5"
          />
          <span v-else>{{ index + 1 }}</span>
        </div>

        <span
          :class="[
            'text-[10px] sm:text-xs font-medium transition-colors text-center',
            currentStep >= index + 1 ? 'text-neutral-950' : 'text-neutral-600',
          ]"
        >
          {{ stepLabel }}
        </span>
      </div>

      <div
        v-if="index < 2"
        :class="[
          'h-0.5 w-8 sm:w-12 md:w-20 mx-1 sm:mx-2 md:mx-3 transition-all',
          currentStep > index + 1 ? 'bg-brand-500' : 'bg-neutral-300',
        ]"
      ></div>
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
