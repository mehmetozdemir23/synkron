<template>
  <form @submit.prevent="$emit('submit')" class="space-y-4">
    <slot />

    <Transition name="slide-down">
      <div
        v-if="error"
        class="flex gap-2 p-3 bg-error-50 border border-error-200 rounded-lg text-error-700 text-sm"
      >
        <AlertCircle class="w-5 h-5 flex-shrink-0 mt-0.5" />
        <p class="font-medium">{{ error }}</p>
      </div>
    </Transition>

    <BaseButton
      type="submit"
      variant="primary"
      size="lg"
      :loading="loading"
      full-width
      class="mt-3"
    >
      <slot name="submit-label">Se connecter</slot>
    </BaseButton>
  </form>
</template>

<script setup>
import { AlertCircle } from "lucide-vue-next";
import BaseButton from "@/components/ui/BaseButton.vue";

defineProps({
  error: String,
  loading: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["submit"]);
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.2s ease-out;
}

.slide-down-enter-from {
  transform: translateY(-8px);
  opacity: 0;
}

.slide-down-leave-to {
  transform: translateY(-8px);
  opacity: 0;
}
</style>
