<template>
  <div class="flex flex-col">
    <label
      v-if="label"
      :for="id"
      :class="[
        'label text-sm font-semibold transition-colors duration-200 mb-2',
        { 'label-required': required },
        error ? 'text-error-600' : 'text-neutral-700',
      ]"
    >
      {{ label }}
    </label>

    <div class="relative group">
      <component
        :is="iconComponent"
        v-if="iconComponent"
        :class="[
          'absolute left-4 top-1/2 -translate-y-1/2 icon-md pointer-events-none transition-smooth',
          error
            ? 'text-error-500'
            : 'text-neutral-600 group-focus-within:text-brand-600',
        ]"
      />

      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :class="inputClasses"
        @input="$emit('update:modelValue', $event.target.value)"
        v-bind="$attrs"
      />

    </div>

    <Transition name="slide-down">
      <p
        v-if="error"
        class="mt-1 text-xs text-error-700 flex items-center gap-1.5 animate-slide-in-right"
      >
        <AlertCircle class="icon-sm flex-shrink-0" />
        <span>{{ error }}</span>
      </p>
      <p v-else-if="hint" class="mt-1 text-xs text-neutral-600">
        {{ hint }}
      </p>
    </Transition>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { AlertCircle } from "lucide-vue-next";

defineOptions({
  inheritAttrs: false,
});

const props = defineProps({
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substring(2, 11)}`,
  },
  label: {
    type: String,
    default: "",
  },
  modelValue: {
    type: [String, Number],
    default: "",
  },
  type: {
    type: String,
    default: "text",
  },
  placeholder: {
    type: String,
    default: "",
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  error: {
    type: String,
    default: "",
  },
  hint: {
    type: String,
    default: "",
  },
  iconComponent: {
    type: [Object, Function],
    default: null,
  },
});

defineEmits(["update:modelValue"]);

const inputClasses = computed(() => {
  const classes = [
    "input-interactive",
    "w-full",
    "px-4",
    "py-3",
    "min-h-[44px]",
    "text-sm",
    "font-medium",
    "text-neutral-900",
    "bg-neutral-100",
    "border",
    "border-neutral-300",
    "rounded-xl",
    "transition-all",
    "duration-200",
    "placeholder:text-neutral-600",
    "placeholder:font-normal",
    "focus:outline-none",
    "focus:border-brand-500",
    "focus:bg-neutral-200",
    "hover:border-neutral-400",
  ];

  if (props.error) {
    classes.push(
      "border-error-500",
      "focus:border-error-500",
      "input-error"
    );
  }

  if (props.disabled) {
    classes.push(
      "bg-neutral-50",
      "cursor-not-allowed",
      "text-neutral-500",
      "border-neutral-200"
    );
  }

  if (props.iconComponent) {
    classes.push("pl-12");
  }

  return classes.join(" ");
});
</script>
