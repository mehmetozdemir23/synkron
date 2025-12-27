<template>
  <router-link to="/" class="flex items-center gap-2 group">
    <img src="@/assets/logo-simple.svg" alt="Synkron" :class="logoClass" />
    <span class="mb-px font-sans text-xl font-[800] text-brand-600">
      <span class="inline-block -mr-[0.03rem]">S</span>ynkron
    </span>
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
    md: "h-8",
    lg: "h-10",
  };
  return `w-auto ${sizeClasses[props.size]}`;
});
</script>
