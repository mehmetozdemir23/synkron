<template>
  <BaseModal :show="alertStore.show" @close="alertStore.close" size="sm">
    <template #header>
      <div class="flex items-center gap-3">
        <component
          :is="getIcon(alertStore.type)"
          :class="['w-6 h-6', getIconColor(alertStore.type)]"
        />
        <span>{{ alertStore.title }}</span>
      </div>
    </template>

    <div class="text-neutral-800">
      {{ alertStore.message }}
    </div>

    <template #footer>
      <div class="flex justify-end">
        <button
          @click="alertStore.close"
          class="px-5 py-2.5 bg-brand-500 text-white rounded-lg font-medium hover:bg-brand-600 active:bg-brand-700 transition-colors"
        >
          OK
        </button>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { useAlertStore } from "@/stores/alert";
import BaseModal from "./BaseModal.vue";
import { Check, CircleAlert, CircleX, Info } from "lucide-vue-next";

const alertStore = useAlertStore();

function getIcon(type) {
  const icons = {
    success: Check,
    error: CircleX,
    warning: CircleAlert,
    info: Info,
  };
  return icons[type] || Info;
}

function getIconColor(type) {
  const colors = {
    success: "text-success-600",
    error: "text-error-600",
    warning: "text-amber-600",
    info: "text-blue-600",
  };
  return colors[type] || "text-blue-600";
}
</script>
