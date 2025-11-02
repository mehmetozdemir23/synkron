<template>
  <div class="flex items-center gap-3 sm:gap-4 md:gap-5 p-3 sm:p-4 md:p-5 bg-neutral-200 rounded-xl border border-neutral-400">
    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full bg-brand-500 flex items-center justify-center flex-shrink-0">
      <User class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" />
    </div>
    <div class="flex-1 min-w-0">
      <h1 class="text-lg sm:text-xl md:text-2xl font-semibold text-neutral-950 mb-0.5 sm:mb-1 truncate">
        {{ professional.business_name || `${professional.firstname} ${professional.lastname}` }}
      </h1>
      <p v-if="professional.activity" class="text-xs sm:text-sm text-neutral-700 flex items-center gap-1.5">
        <Briefcase class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-brand-500 flex-shrink-0" />
        <span class="truncate">{{ professional.activity }}</span>
      </p>
    </div>
  </div>
</template>

<script setup>
import { User, Briefcase } from "lucide-vue-next";

defineProps({
  professional: {
    type: Object,
    required: true,
  },
});
</script>
