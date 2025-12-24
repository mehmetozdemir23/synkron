<template>
  <div class="flex items-center justify-center gap-1.5 sm:gap-3">
    <div
      v-for="(stepLabel, index) in ['Service', 'Date', 'Infos']"
      :key="index + 1"
      class="flex items-center"
    >
      <div class="flex flex-col items-center gap-1.5 sm:gap-2">
        <div
          :class="[
            'w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-xs font-semibold transition-all duration-300',
            currentStep > index + 1
              ? 'bg-brand-600 text-white shadow-md'
              : currentStep === index + 1
              ? 'bg-gradient-to-br from-brand-500 to-brand-600 text-white shadow-md ring-4 ring-brand-100'
              : 'bg-neutral-200 text-neutral-500 border-2 border-neutral-300',
          ]"
        >
          <CheckCircle v-if="currentStep > index + 1" class="w-4 h-4" />
          <span v-else>{{ index + 1 }}</span>
        </div>

        <span
          :class="[
            'text-xs font-semibold transition-colors text-center whitespace-nowrap',
            currentStep >= index + 1 ? 'text-brand-700' : 'text-neutral-500',
          ]"
        >
          {{ stepLabel }}
        </span>
      </div>

      <div v-if="index < 2" class="flex items-center h-8 sm:h-9 mb-5">
        <div
          :class="[
            'h-[2px] w-8 sm:w-16 md:w-20 mx-2 sm:mx-3 transition-all duration-300 rounded-full',
            currentStep > index + 1 ? 'bg-brand-400' : 'bg-neutral-200',
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
