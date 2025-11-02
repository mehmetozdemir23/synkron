<template>
  <div
    class="relative overflow-hidden bg-neutral-200 rounded-2xl border border-neutral-400 p-8 sm:p-12 text-center"
  >
    <div
      class="absolute top-0 right-0 w-40 h-40 bg-brand-100 rounded-full opacity-20 -mr-20 -mt-20"
    ></div>
    <div
      class="absolute bottom-0 left-0 w-40 h-40 bg-accent-100 rounded-full opacity-20 -ml-20 -mb-20"
    ></div>

    <div class="relative z-10">
      <div
        v-if="icon"
        class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-brand-200 flex items-center justify-center mx-auto mb-6 border border-brand-400"
      >
        <component
          :is="icon"
          class="w-10 h-10 sm:w-12 sm:h-12 text-brand-800"
        />
      </div>

      <h3 class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-3">
        {{ title }}
      </h3>

      <p class="text-sm sm:text-base text-neutral-700 mb-8 max-w-sm mx-auto">
        {{ description }}
      </p>

      <BaseButton
        v-if="action"
        @click="action.onClick"
        variant="primary"
        class="px-6"
      >
        {{ action.label }}
      </BaseButton>
      <slot name="action" />
    </div>
  </div>
</template>

<script setup>
import BaseButton from "./BaseButton.vue";

defineProps({
  icon: {
    type: Object,
    default: null,
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  action: {
    type: Object,
    default: null,
  },
});
</script>
