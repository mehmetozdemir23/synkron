<template>
  <div class="flex-1 flex items-center justify-center">
    <div class="text-center max-w-md mx-auto px-4">
      <div
        class="w-16 h-16 rounded-full bg-gradient-to-br from-error-100 to-error-50 flex items-center justify-center mx-auto mb-4"
      >
        <AlertCircle class="w-8 h-8 text-error-600" />
      </div>
      <h2 class="text-2xl font-bold text-neutral-900 mb-2">
        Professionnel non trouvé
      </h2>
      <p class="text-sm text-neutral-600">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { AlertCircle } from "lucide-vue-next";

defineProps({
  error: {
    type: String,
    required: true,
  },
});
</script>
