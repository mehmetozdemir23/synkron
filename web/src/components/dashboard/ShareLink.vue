<template>
  <div class="flex items-center gap-3 min-w-0 sm:min-w-fit">
    <Link2 class="w-4 h-4 text-neutral-600 flex-shrink-0" />
    <code
      class="text-xs sm:text-sm text-neutral-950 font-mono truncate sm:truncate"
      >{{ url }}</code
    >
    <button
      @click="copyToClipboard(url)"
      :class="[
        'py-2 px-4 rounded-lg font-medium text-xs flex justify-center items-center gap-1.5 whitespace-nowrap flex-shrink-0',
        isCopied
          ? 'bg-neutral-300 text-neutral-800 transition-colors'
          : 'bg-brand-500 text-white hover:bg-brand-600 hover:shadow-sm active:bg-brand-700 transition-all',
      ]"
      :title="label"
    >
      <Check v-if="isCopied" class="w-3.5 h-3.5" />
      <Copy v-else class="w-3.5 h-3.5" />
      <span class="hidden sm:inline">{{ label }}</span>
    </button>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Copy, Check, Link2 } from "lucide-vue-next";

defineProps({
  url: {
    type: String,
    required: true,
  },
});

const isCopied = ref(false);
const label = computed(() => (isCopied.value ? "Copié!" : "Copier le lien"));

async function copyToClipboard(text) {
  try {
    await navigator.clipboard.writeText(text);
    isCopied.value = true;
    setTimeout(() => {
      isCopied.value = false;
    }, 2000);
  } catch (error) {
    console.error("Failed to copy to clipboard:", error);
  }
}
</script>
