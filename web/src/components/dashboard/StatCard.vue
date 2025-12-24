<template>
  <div
    :class="[
      'bg-white rounded-xl p-5 border border-neutral-200 flex flex-col justify-between h-full overflow-hidden',
      bgClass,
    ]"
  >
    <div>
      <div class="flex items-center justify-between mb-3">
        <p :class="['text-sm font-medium', labelColor]">{{ label }}</p>
        <component :is="resolvedIcon" :class="['icon-md', iconColor]" />
      </div>
      <p class="text-3xl sm:text-4xl font-bold text-neutral-900">
        {{ value }}
      </p>
    </div>
    <p :class="['text-xs mt-2', sublabelColor]">{{ sublabel }}</p>
  </div>
</template>

<script setup>
import { CheckCircle, DollarSign, AlertCircle } from "lucide-vue-next";
import { computed } from "vue";

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  sublabel: {
    type: String,
    default: "",
  },
  iconComponent: {
    type: String,
    required: true,
    validator: (value) =>
      ["CheckCircle", "DollarSign", "AlertCircle"].includes(value),
  },
  iconColor: {
    type: String,
    default: "text-neutral-600",
  },
  bgClass: {
    type: String,
    default: "",
  },
  labelColor: {
    type: String,
    default: "text-neutral-700",
  },
  sublabelColor: {
    type: String,
    default: "text-neutral-500",
  },
});

const iconMap = {
  CheckCircle,
  DollarSign,
  AlertCircle,
};

const resolvedIcon = computed(() => iconMap[props.iconComponent]);
</script>
