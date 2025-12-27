<template>
  <Teleport to="body">
    <Transition name="modal-fade">
      <div
        v-if="show"
        class="fixed inset-0 z-50 bg-neutral-900/40 backdrop-blur-sm flex items-center justify-center p-4"
        @click.self="close"
        :key="show"
      >
        <div
          :class="[
            'max-h-[85vh] bg-neutral-50 rounded-xl w-full shadow-lg border border-neutral-200 overflow-hidden flex flex-col',
            sizeClass,
          ]"
        >
          <div
            v-if="$slots.header || title"
            class="flex items-center justify-between px-6 py-4 border-b border-neutral-200 bg-neutral-100 flex-shrink-0"
          >
            <h2 class="text-lg font-semibold text-neutral-900">
              <slot name="header">{{ title }}</slot>
            </h2>
            <button
              @click="close"
              :disabled="processing"
              class="p-2 hover:bg-neutral-200 active:bg-neutral-300 rounded-lg transition-smooth disabled:opacity-50 flex-shrink-0 group flex items-center justify-center"
            >
              <X
                class="w-5 h-5 text-neutral-600 group-hover:text-neutral-900 transition-smooth"
              />
            </button>
          </div>

          <div class="overflow-y-auto flex-1 p-6">
            <slot />
          </div>

          <div
            v-if="$slots.footer"
            class="border-t border-neutral-200 px-6 py-4 bg-neutral-100 flex-shrink-0"
          >
            <slot name="footer" />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed } from "vue";
import { X } from "lucide-vue-next";

const props = defineProps({
  show: Boolean,
  title: {
    type: String,
    default: "",
  },
  processing: {
    type: Boolean,
    default: false,
  },
  size: {
    type: String,
    default: "md",
    validator: (value) => ["sm", "md", "lg", "xl"].includes(value),
  },
});

const emit = defineEmits(["close"]);

const sizeClass = computed(() => {
  switch (props.size) {
    case "sm":
      return "max-w-sm";
    case "md":
      return "max-w-md";
    case "lg":
      return "max-w-2xl";
    case "xl":
      return "max-w-4xl";
    default:
      return "max-w-md";
  }
});

function close() {
  emit("close");
}
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active > div,
.modal-fade-leave-active > div {
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-fade-enter-from > div,
.modal-fade-leave-to > div {
  transform: scale(0.95) translateY(8px);
}
</style>
