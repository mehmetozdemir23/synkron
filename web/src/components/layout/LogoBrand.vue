<template>
  <router-link to="/" class="flex items-center gap-2.5 group">
    <img src="@/assets/logo.svg" alt="Synkron" :class="logoClass" />
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
    sm: "h-6",
    md: "h-10",
    lg: "h-12",
  };
  return `w-auto transition-transform group-hover:scale-105 ${
    sizeClasses[props.size]
  }`;
});
</script>
