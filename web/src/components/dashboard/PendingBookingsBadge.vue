<template>
  <button
    v-if="pendingCount > 0"
    @click="$emit('show-pending-modal')"
    class="min-h-0 flex items-center text-xs text-warning-800 rounded-full gap-2 bg-warning-300 hover:bg-warning-400 active:bg-warning-400 px-2.5 py-1"
  >
    <div class="w-1.5 h-1.5 rounded-full bg-warning-500"></div>
    <span class="mb-0.5"
      >{{ pendingCount }}
      <span v-if="showFullText"
        >réservation{{ pendingCount > 1 ? "s" : "" }}</span
      >
      en attente</span
    >
    <ArrowRight :class="'icon-' + iconSize" />
  </button>
</template>
<script setup>
import { ArrowRight } from "lucide-vue-next";

defineProps({
  pendingCount: {
    type: [String, Number],
    required: true,
    validator: (value) => value > 0,
  },
  iconSize: {
    type: String,
    default: "md",
    validator: (value) => ["sm", "md", "lg"].includes(value),
  },
  showFullText: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["show-pending-modal"]);
</script>
