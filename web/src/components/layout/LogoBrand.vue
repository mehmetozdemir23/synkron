<template>
  <router-link to="/" class="flex items-center gap-2 group">
    <img src="@/assets/logo-simple.svg" alt="Synkron" :class="logoClass" />
    <span class="font-sans text-lg font-semibold text-neutral-900"
      >Synkron</span
    >
  </router-link>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  size: {
    type: String,
    default: "md",
    validator: (value) => ["sm", "md", "lg"].includes(value),
  },
});

const logoClass = computed(() => {
  const sizeClasses = {
    sm: "h-5",
    md: "h-8",
    lg: "h-10",
  };
  return `w-auto ${sizeClasses[props.size]}`;
});
</script>
