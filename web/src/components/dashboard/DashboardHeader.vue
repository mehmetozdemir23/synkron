<template>
  <div
    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
  >
    <div class="flex-1 min-w-0">
      <h1 class="text-2xl font-normal text-neutral-900">
        Bonjour, {{ userName }}
      </h1>
    </div>
    <div class="w-full sm:w-auto sm:flex-shrink-0">
      <ShareLink :url="publicUrl" />
    </div>
  </div>
</template>

<script setup>
import ShareLink from "./ShareLink.vue";

defineProps({
  userName: {
    type: String,
    required: true,
  },
  publicUrl: {
    type: String,
    required: true,
  },
});
</script>
