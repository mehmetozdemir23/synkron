<template>
  <router-link
    :to="to"
    class="bottom-nav-item group flex flex-col items-center justify-center gap-1 px-1 py-2 transition-all duration-200 relative flex-1 min-w-[64px] max-w-[96px]"
    :class="{ active: isActive }"
    @click="$emit('click')"
  >
    <div
      :class="[
        'relative flex items-center justify-center w-16 h-8 rounded-full transition-all duration-200',
        isActive
          ? 'bg-brand-100'
          : 'group-hover:bg-neutral-200/50 group-active:bg-neutral-200',
      ]"
    >
      <component
        :is="icon"
        :class="[
          'w-6 h-6 transition-all duration-200',
          isActive
            ? 'text-brand-700'
            : 'text-neutral-700 group-hover:text-neutral-900',
        ]"
      />
    </div>
    <span
      :class="[
        'text-[11px] font-medium transition-all duration-200 leading-none text-center px-1',
        isActive
          ? 'text-neutral-900'
          : 'text-neutral-700',
      ]"
    >
      {{ label }}
    </span>
  </router-link>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const props = defineProps({
  to: {
    type: String,
    required: true,
  },
  icon: {
    type: [Object, Function],
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  exact: {
    type: Boolean,
    default: true,
  },
});

defineEmits(["click"]);

const route = useRoute();

const isActive = computed(() => {
  if (props.exact) {
    return route.path === props.to;
  }
  return route.path.startsWith(props.to);
});
</script>
