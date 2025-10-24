<template>
  <div class="relative">
    <div class="relative">
      <Briefcase
        class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400"
      />
      <input
        v-model="searchQuery"
        type="text"
        :placeholder="placeholder"
        @focus="isOpen = true"
        @blur="handleBlur"
        @input="handleInput"
        @keydown.down="handleKeyDown"
        @keydown.up="handleKeyUp"
        @keydown.enter="selectHighlighted"
        @keydown.escape="isOpen = false"
        class="w-full pl-12 pr-4 py-3 text-base rounded-lg border border-neutral-300 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all"
      />
    </div>

    <Transition name="dropdown">
      <div
        v-if="isOpen && filteredProfessions.length > 0"
        class="absolute top-full left-0 right-0 mt-2 bg-neutral-100 border border-neutral-300 rounded-lg shadow-lg z-50"
      >
        <ul class="max-h-60 overflow-y-auto">
          <li
            v-for="(profession, index) in filteredProfessions"
            :key="profession"
            @click="selectProfession(profession)"
            @mouseenter="highlightedIndex = index"
            :class="[
              'px-4 py-2.5 text-sm cursor-pointer transition-colors',
              index === highlightedIndex
                ? 'bg-brand-50 text-brand-700 font-medium'
                : 'text-neutral-900 hover:bg-neutral-50',
            ]"
          >
            {{ profession }}
          </li>
        </ul>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Briefcase } from "lucide-vue-next";
import { filterProfessions } from "@/constants/professions";

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Psychologue",
  },
});

const emit = defineEmits(["update:modelValue"]);

const searchQuery = ref(props.modelValue);
const isOpen = ref(false);
const highlightedIndex = ref(0);

const filteredProfessions = computed(() => {
  return filterProfessions(searchQuery.value);
});

function handleInput(e) {
  searchQuery.value = e.target.value;
  highlightedIndex.value = 0;
  isOpen.value = true;
}

function handleBlur() {
  setTimeout(() => {
    isOpen.value = false;
  }, 150);
}

function handleKeyDown() {
  if (highlightedIndex.value < filteredProfessions.value.length - 1) {
    highlightedIndex.value++;
  }
}

function handleKeyUp() {
  if (highlightedIndex.value > 0) {
    highlightedIndex.value--;
  }
}

function selectHighlighted() {
  if (filteredProfessions.value[highlightedIndex.value]) {
    selectProfession(filteredProfessions.value[highlightedIndex.value]);
  }
}

function selectProfession(profession) {
  searchQuery.value = profession;
  emit("update:modelValue", profession);
  isOpen.value = false;
}
</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.15s ease;
}

.dropdown-enter-from {
  opacity: 0;
  transform: translateY(-8px);
}

.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
