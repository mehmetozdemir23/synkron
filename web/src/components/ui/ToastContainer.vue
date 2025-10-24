<template>
  <div class="fixed top-4 right-4 z-50 space-y-3">
    <TransitionGroup name="toast">
      <div
        v-for="toast in toastStore.toasts"
        :key="toast.id"
        :class="toastClasses(toast.type)"
        @click="toastStore.removeToast(toast.id)"
      >
        <div class="flex items-start gap-3">
          <div :class="toastIconClasses(toast.type)">
            <span class="text-sm">{{ getIcon(toast.type) }}</span>
          </div>
          <p class="flex-1 font-medium pt-0.5">{{ toast.message }}</p>
          <button class="flex-shrink-0 text-neutral-400 hover:text-neutral-600 transition-colors pt-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { useToastStore } from '@/stores/toast'

const toastStore = useToastStore()

function toastClasses(type) {
  const baseClasses = 'min-w-[320px] max-w-md p-4 rounded-xl shadow-md hover:shadow-lg cursor-pointer transition-all duration-300 border'

  const typeClasses = {
    success: 'bg-gradient-to-r from-success-50 to-success-50/50 border-success-300 text-success-700',
    error: 'bg-gradient-to-r from-error-50 to-error-50/50 border-error-300 text-error-700',
    warning: 'bg-gradient-to-r from-yellow-50 to-yellow-50/50 border-yellow-300 text-yellow-700',
    info: 'bg-gradient-to-r from-blue-50 to-blue-50/50 border-blue-300 text-blue-700'
  }

  return `${baseClasses} ${typeClasses[type]}`
}

function toastIconClasses(type) {
  const baseClasses = 'w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0'

  const typeClasses = {
    success: 'bg-success-200 text-success-700',
    error: 'bg-error-200 text-error-700',
    warning: 'bg-yellow-200 text-yellow-700',
    info: 'bg-blue-200 text-blue-700'
  }

  return `${baseClasses} ${typeClasses[type]}`
}

function getIcon(type) {
  const icons = {
    success: '✓',
    error: '✗',
    warning: '⚠',
    info: 'ℹ'
  }
  return icons[type]
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
