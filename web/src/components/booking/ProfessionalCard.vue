<template>
  <div class="flex items-center gap-3 sm:gap-4 pb-4 sm:pb-5 border-b border-neutral-200">
    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-neutral-500 flex items-center justify-center flex-shrink-0">
      <User class="w-6 h-6 sm:w-7 sm:h-7 text-white" />
    </div>
    <div class="flex-1 min-w-0">
      <h1 class="text-xl sm:text-2xl font-bold text-neutral-950 mb-0.5 truncate">
        {{ professional.business_name || `${professional.firstname} ${professional.lastname}` }}
      </h1>
      <p v-if="professional.activity" class="text-sm text-neutral-800 flex items-center gap-1.5">
        <Briefcase class="w-4 h-4 flex-shrink-0" />
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
