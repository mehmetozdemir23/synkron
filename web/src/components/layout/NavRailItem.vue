<template>
  <router-link
    :to="to"
    :title="title"
    class="relative flex flex-col items-center justify-center gap-1 py-2 text-neutral-600 rounded-2xl hover:text-neutral-700 [&.router-link-exact-active_.icon-container]:bg-neutral-200 [&.router-link-exact-active]:text-neutral-900 [&.router-link-exact-active_.label]:font-semibold"
  >
    <div
      class="icon-container flex items-center justify-center w-12 h-12 rounded-full hover:bg-neutral-200 transition-smooth"
    >
      <component :is="icon" class="icon-content icon-md" />
    </div>
    <span class="label text-xs font-medium leading-tight text-center">{{ label }}</span>
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
