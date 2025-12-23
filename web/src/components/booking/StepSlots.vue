<template>
  <div class="space-y-4">
    <div class="flex items-center gap-2 flex-wrap">
      <div v-if="selectedService" class="flex items-center gap-1.5 px-2.5 py-1.5 bg-neutral-200 text-neutral-800 rounded-lg border border-neutral-300">
        <Clock class="w-4 h-4" />
        <span class="text-sm font-medium whitespace-nowrap">{{ selectedService.duration_minutes }} min</span>
      </div>
      <div class="flex items-center gap-1.5 px-2.5 py-1.5 bg-neutral-200 text-neutral-700 rounded-lg border border-neutral-300">
        <span class="text-sm font-medium whitespace-nowrap">{{ formatTimezone(professionalTimezone) }}</span>
      </div>
    </div>

    <div v-if="loading" class="flex items-center justify-center py-8 sm:py-12">
      <div class="text-center">
        <div class="w-8 h-8 sm:w-10 sm:h-10 border-4 border-brand-200 border-t-brand-500 rounded-full animate-spin mx-auto mb-2 sm:mb-3"></div>
        <p class="text-xs sm:text-sm text-neutral-600">Chargement des créneaux...</p>
      </div>
    </div>

    <div v-else-if="slotsByDay.length > 0" class="space-y-4">
      <div class="space-y-2">
        <div class="flex gap-1.5 sm:gap-2 overflow-x-auto pb-2 -mx-1 px-1">
          <button
            v-for="(day, index) in slotsByDay"
            :key="day.date"
            @click="selectDay(index)"
            :aria-label="`Sélectionner ${day.fullDate}`"
            :aria-pressed="props.selectedDayIndex === index"
            :class="[
              'flex-shrink-0 px-3 py-2 sm:px-4 sm:py-3 rounded-lg border-2 text-center min-w-[64px] sm:min-w-[70px] transition-all',
              props.selectedDayIndex === index
                ? 'border-neutral-400 bg-neutral-200/50 shadow-sm'
                : 'border-neutral-300 bg-neutral-100/50 hover:border-neutral-400',
            ]"
          >
            <div class="text-[11px] sm:text-xs md:text-sm font-medium text-neutral-950">{{ day.dayName }}</div>
            <div class="text-[10px] sm:text-xs text-neutral-800 mt-0.5">{{ day.dayNumber }}</div>
          </button>
        </div>
      </div>

      <div v-if="slotsByDay[props.selectedDayIndex]" class="space-y-2">
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2">
          <button
            v-for="slot in slotsByDay[props.selectedDayIndex].slots"
            :key="slot.start_at"
            @click="selectSlot(slot)"
            :class="[
              'py-2.5 sm:py-2.5 px-2 sm:px-2 rounded-lg border-2 text-center text-[11px] sm:text-xs md:text-sm font-medium transition-all',
              selectedSlot?.start_at === slot.start_at
                ? 'border-neutral-400 bg-neutral-200 text-neutral-950 shadow-sm'
                : 'border-neutral-300 bg-neutral-50 text-neutral-950 hover:border-neutral-400',
            ]"
          >
            {{ formatSlotTime(slot.start_at) }}
          </button>
        </div>
      </div>
    </div>

    <div v-else class="flex items-center justify-center py-8 sm:py-12">
      <div class="text-center">
        <CalendarDays class="w-10 h-10 sm:w-12 sm:h-12 text-neutral-500 mx-auto mb-2 sm:mb-3" />
        <p class="text-sm sm:text-base font-medium text-neutral-900 mb-0.5 sm:mb-1">Aucun créneau disponible</p>
        <p class="text-xs sm:text-sm text-neutral-600">Veuillez sélectionner un autre service</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { CalendarDays, Clock } from "lucide-vue-next";

const props = defineProps({
  slotsByDay: {
    type: Array,
    required: true,
  },
  selectedSlot: {
    type: Object,
    default: null,
  },
  selectedDayIndex: {
    type: Number,
    default: 0,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  selectedService: {
    type: Object,
    default: null,
  },
  professionalTimezone: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(["select-day", "select-slot"]);

function selectSlot(slot) {
  emit("select-slot", slot);
}

function selectDay(index) {
  emit("select-day", index);
}

function formatSlotTime(dateString) {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat("fr-FR", {
    hour: "2-digit",
    minute: "2-digit",
    timeZone: props.professionalTimezone,
  }).format(date);
}

function formatTimezone(timezone) {
  const date = new Date();
  const formatter = new Intl.DateTimeFormat("fr-FR", {
    timeZone: timezone,
    timeZoneName: "short",
  });
  const parts = formatter.formatToParts(date);
  const timeZoneName = parts.find(part => part.type === "timeZoneName")?.value;
  return timeZoneName || timezone;
}
</script>
