<template>
  <div class="fixed top-4 right-4 z-50 space-y-3">
    <TransitionGroup name="toast">
      <div
        v-for="toast in toastStore.toasts"
        :key="toast.id"
        :class="toastClasses(toast.type)"
        @click="toastStore.removeToast(toast.id)"
      >
        <div class="flex items-center gap-3">
          <component :is="getIcon(toast.type)" class="w-5 h-5 flex-shrink-0" />
          <p class="flex-1 font-medium">{{ toast.message }}</p>
          <X class="w-4 h-4 flex-shrink-0 opacity-60" />
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { useToastStore } from "@/stores/toast";
import { Check, CircleAlert, CircleX, Info, X } from "lucide-vue-next";

const toastStore = useToastStore();

function toastClasses(type) {
  const baseClasses =
    "min-w-[320px] max-w-md p-4 rounded-xl shadow-lg cursor-pointer transition-all border";

  const typeClasses = {
    success: "bg-success-50 border-success-200 text-success-800",
    error: "bg-error-50 border-error-200 text-error-800",
    warning: "bg-amber-50 border-amber-200 text-amber-800",
    info: "bg-blue-50 border-blue-200 text-blue-800",
  };

  return `${baseClasses} ${typeClasses[type]}`;
}

function getIcon(type) {
  const icons = {
    success: Check,
    error: CircleX,
    warning: CircleAlert,
    info: Info,
  };
  return icons[type];
}
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100px);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100px) scale(0.9);
}
</style>
