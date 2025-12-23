<template>
  <component
    :is="clickable ? 'button' : 'div'"
    @click="clickable ? $emit('click') : null"
    :class="[
      'group relative bg-neutral-100 rounded-xl shadow-md transition-all duration-200 overflow-hidden',
      clickable ? 'cursor-pointer hover:shadow-lg hover:shadow-neutral-900/5' : 'cursor-default',
    ]"
  >
    <div class="absolute top-3 right-3 opacity-10 pointer-events-none">
      <component :is="icon" :class="['w-20 h-20', iconColor]" />
    </div>

    <div class="relative p-6 z-10">
      <div class="text-sm font-medium text-neutral-600 mb-2">
        {{ label }}
      </div>
      <div class="text-3xl font-normal text-neutral-900">
        {{ value }}
      </div>
    </div>
  </component>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  icon: {
    type: [Object, Function],
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  color: {
    type: String,
    default: "neutral",
    validator: (value) =>
      ["amber", "green", "blue", "purple", "neutral"].includes(value),
  },
  clickable: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["click"]);

function getColorScheme(colorType) {
  const colorMap = {
    amber: {
      iconColor: "text-amber-600",
    },
    green: {
      iconColor: "text-green-600",
    },
    blue: {
      iconColor: "text-blue-600",
    },
    purple: {
      iconColor: "text-purple-600",
    },
    neutral: {
      iconColor: "text-neutral-600",
    },
  };

  return colorMap[colorType] || colorMap.neutral;
}

const colorScheme = computed(() => getColorScheme(props.color));

const iconColor = computed(() => colorScheme.value.iconColor);
</script>
