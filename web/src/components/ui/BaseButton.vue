<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="handleClick"
  >
    <Loader2 v-if="loading" class="w-4 h-4 animate-spin" />
    <slot />
  </button>
</template>

<script setup>
import { computed } from "vue";
import { Loader2 } from "lucide-vue-next";

const props = defineProps({
  variant: {
    type: String,
    default: "primary",
    validator: (value) =>
      ["primary", "secondary", "ghost", "danger", "success"].includes(value),
  },
  size: {
    type: String,
    default: "md",
    validator: (value) => ["sm", "md", "lg"].includes(value),
  },
  type: {
    type: String,
    default: "button",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  fullWidth: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["click"]);

const buttonClasses = computed(() => {
  const classes = ["btn"];

  if (props.variant === "primary") {
    classes.push("btn-primary");
  } else if (props.variant === "secondary") {
    classes.push("btn-secondary");
  } else if (props.variant === "ghost") {
    classes.push("btn-ghost");
  } else if (props.variant === "danger") {
    classes.push("btn-danger");
  } else if (props.variant === "success") {
    classes.push(
      "bg-success-600",
      "text-white",
      "hover:bg-success-700",
      "hover:shadow-sm",
      "active:bg-success-800",
      "transition-all"
    );
  }

  if (props.size === "sm") {
    classes.push("btn-sm");
  } else if (props.size === "lg") {
    classes.push("btn-lg");
  }

  if (props.fullWidth) {
    classes.push("w-full");
  }

  return classes.join(" ");
});

function handleClick(event) {
  if (!props.disabled && !props.loading) {
    emit("click", event);
  }
}
</script>
