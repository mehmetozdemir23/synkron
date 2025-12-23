<template>
  <router-link to="/" class="flex items-center gap-2.5 group">
    <img src="@/assets/logo-simple.svg" alt="Synkron" :class="logoClass" />
    <span class="font-sans text-2xl font-semibold text-neutral-800 mb-px"
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
    sm: "h-7",
    md: "h-9",
    lg: "h-11",
  };
  return `w-auto ${sizeClasses[props.size]}`;
});
</script>
