<template>
  <router-link
    :to="to"
    :title="title"
    class="relative flex flex-col items-center justify-center gap-0.5 py-1.5 text-neutral-600 rounded-2xl hover:text-neutral-800 [&.router-link-exact-active_.icon-container]:bg-neutral-300 [&.router-link-exact-active]:text-neutral-900 [&.router-link-exact-active_.label]:font-semibold"
  >
    <div
      class="icon-container flex items-center justify-center w-12 h-12 rounded-full hover:bg-neutral-300"
    >
      <component :is="icon" class="icon-content w-5 h-5" />
    </div>
    <span class="label text-xs font-medium">{{ label }}</span>
  </router-link>
</template>

<script setup>
defineProps({
  to: {
    type: String,
    required: true,
  },
  icon: {
    type: Function,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
});
</script>
