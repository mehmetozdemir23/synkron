<template>
  <Transition name="slide-down">
    <div
      v-if="show"
      :class="[
        'flex items-start gap-4 p-5 rounded-xl border transition-all duration-200 shadow-sm',
        variantClasses,
      ]"
    >
      <component
        :is="iconComponent"
        :class="['w-5 h-5 flex-shrink-0 mt-0.5', iconColorClass]"
      />
      <div class="flex-1">
        <p v-if="title" :class="['font-semibold', textColorClass]">
          {{ title }}
        </p>
        <p :class="[title ? 'text-sm mt-1' : 'text-sm', textColorClass]">
          <slot>{{ message }}</slot>
        </p>
      </div>
      <button
        v-if="dismissible"
        @click="show = false"
        :class="['p-1 hover:bg-neutral-100 active:bg-neutral-200 rounded transition-colors flex-shrink-0', textColorClass]"
      >
        <X class="w-4 h-4" />
      </button>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed } from "vue";
import {
  AlertCircle,
  CheckCircle,
  AlertTriangle,
  Info,
  X,
} from "lucide-vue-next";

const props = defineProps({
  variant: {
    type: String,
    default: "info",
    validator: (v) => ["success", "error", "warning", "info"].includes(v),
  },
  title: String,
  message: String,
  dismissible: {
    type: Boolean,
    default: false,
  },
  modelValue: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(["update:modelValue"]);

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

const iconComponent = computed(() => {
  switch (props.variant) {
    case "success":
      return CheckCircle;
    case "error":
      return AlertCircle;
    case "warning":
      return AlertTriangle;
    default:
      return Info;
  }
});

const variantClasses = computed(() => {
  switch (props.variant) {
    case "success":
      return "bg-success-100 border-success-300";
    case "error":
      return "bg-error-100 border-error-300";
    case "warning":
      return "bg-warning-100 border-warning-300";
    default:
      return "bg-neutral-100 border-neutral-300";
  }
});

const textColorClass = computed(() => {
  switch (props.variant) {
    case "success":
      return "text-success-900";
    case "error":
      return "text-error-900";
    case "warning":
      return "text-warning-900";
    default:
      return "text-neutral-900";
  }
});

const iconColorClass = computed(() => {
  switch (props.variant) {
    case "success":
      return "text-success-700";
    case "error":
      return "text-error-700";
    case "warning":
      return "text-warning-700";
    default:
      return "text-neutral-600";
  }
});
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.2s ease-out;
}

.slide-down-enter-from {
  transform: translateY(-8px);
  opacity: 0;
}

.slide-down-leave-to {
  transform: translateY(-8px);
  opacity: 0;
}
</style>
