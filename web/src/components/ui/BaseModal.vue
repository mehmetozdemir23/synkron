<template>
  <Teleport to="body">
    <Transition name="modal-fade">
      <div
        v-if="show"
        class="fixed inset-0 z-50 bg-black/25 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 md:p-6"
        @click.self="close"
        :key="show"
      >
        <div
          :class="[
            'max-h-[80vh] sm:max-h-[90vh] bg-neutral-100 rounded-2xl w-full shadow-xl overflow-hidden transition-all duration-300 ease-out',
            sizeClass,
          ]"
        >
          <div
            v-if="$slots.header"
            class="flex items-center justify-between p-5 sm:p-6 md:p-7 border-b border-neutral-300"
          >
            <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-neutral-900">
              <slot name="header" />
            </h2>
            <button
              @click="close"
              :disabled="processing"
              class="min-w-[44px] min-h-[44px] p-2.5 hover:bg-neutral-200 active:bg-neutral-400 rounded-xl transition-colors disabled:opacity-50 flex-shrink-0 group flex items-center justify-center"
            >
              <X
                class="w-5 h-5 text-neutral-600 group-hover:text-neutral-900 transition-colors"
              />
            </button>
          </div>

          <div class="p-5 sm:p-6 md:p-7">
            <slot />
          </div>

          <div
            v-if="$slots.footer"
            class="border-t border-neutral-300 p-5 sm:p-6 md:p-7 bg-neutral-100"
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
