<template>
  <div class="flex justify-between items-center gap-3 w-full">
    <Link2 class="icon-sm text-brand-500 flex-shrink-0" />
    <code
      class="text-xs sm:text-sm text-neutral-900 font-mono font-semibold truncate flex-1 min-w-0"
    >
      {{ url }}
    </code>
    <button
      @click="copyToClipboard(url)"
      class="py-2 px-4 rounded-lg bg-neutral-200 text-neutral-900 hover:bg-neutral-300 font-semibold text-xs flex items-center justify-center gap-1.5 whitespace-nowrap flex-shrink-0 transition-smooth w-[36px] sm:w-[130px]"
      :title="label"
    >
      <Check v-if="isCopied" class="icon-xs" />
      <Copy v-else class="icon-xs" />
      <span class="hidden sm:inline">{{ label }}</span>
    </button>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Copy, Check, Link2 } from "lucide-vue-next";
import { logError } from "@/utils/logger";

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
    logError("ShareLink.copyToClipboard", error);
  }
}
</script>
