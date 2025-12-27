<template>
  <div class="border-t border-neutral-200 p-3 sm:p-4 flex-shrink-0 bg-white backdrop-blur-sm">
    <div v-if="currentStep === 1" class="flex justify-end">
      <BaseButton
        @click="emit('go-to-step', 2)"
        :disabled="!selectedService"
        variant="primary"
        size="md"
      >
        <span class="hidden sm:inline">Continuer</span>
        <span class="sm:hidden">Suivant</span>
        <ChevronRight class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
      </BaseButton>
    </div>

    <div v-else-if="currentStep === 2" class="flex justify-between gap-2 sm:gap-3">
      <BaseButton
        @click="emit('go-to-step', 1)"
        variant="secondary"
        size="md"
      >
        <ChevronLeft class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
        Retour
      </BaseButton>
      <BaseButton
        @click="emit('go-to-step', 3)"
        :disabled="!selectedSlot"
        variant="primary"
        size="md"
      >
        <span class="hidden sm:inline">Continuer</span>
        <span class="sm:hidden">Suivant</span>
        <ChevronRight class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
      </BaseButton>
    </div>

    <div v-else-if="currentStep === 3" class="flex justify-between gap-2 sm:gap-3">
      <BaseButton
        @click="emit('go-to-step', 2)"
        variant="secondary"
        :disabled="bookingInProgress"
        size="md"
      >
        <ChevronLeft class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
        Retour
      </BaseButton>
      <BaseButton
        @click="emit('create-booking')"
        :loading="bookingInProgress"
        variant="primary"
        size="md"
      >
        <Check class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
        <span class="hidden sm:inline">Confirmer la réservation</span>
        <span class="sm:hidden">Confirmer</span>
      </BaseButton>
    </div>
  </div>
</template>

<script setup>
import BaseButton from "@/components/ui/BaseButton.vue";
import { ChevronRight, ChevronLeft, Check } from "lucide-vue-next";

defineProps({
  currentStep: {
    type: Number,
    required: true,
  },
  selectedService: {
    type: Object,
    default: null,
  },
  selectedSlot: {
    type: Object,
    default: null,
  },
  bookingInProgress: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["go-to-step", "create-booking"]);
</script>
