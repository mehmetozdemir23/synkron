<template>
  <div class="space-y-4">
    <div class="flex items-center gap-2 flex-wrap">
      <div v-if="selectedService" class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-br from-brand-50 to-brand-100/50 text-brand-700 rounded-lg border border-brand-200">
        <Clock class="w-4 h-4" />
        <span class="text-sm font-semibold whitespace-nowrap">{{ selectedService.duration_minutes }} min</span>
      </div>
      <div class="flex items-center gap-1.5 px-3 py-2 bg-neutral-50 text-neutral-700 rounded-lg border border-neutral-200">
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
                ? 'border-brand-600 bg-gradient-to-br from-brand-50 to-brand-100/50 shadow-md'
                : 'border-neutral-200 bg-white hover:border-brand-400 hover:shadow-sm',
            ]"
          >
            <div :class="[
              'text-[11px] sm:text-xs md:text-sm font-semibold',
              props.selectedDayIndex === index ? 'text-brand-700' : 'text-neutral-900'
            ]">{{ day.dayName }}</div>
            <div :class="[
              'text-[10px] sm:text-xs mt-0.5',
              props.selectedDayIndex === index ? 'text-brand-600' : 'text-neutral-600'
            ]">{{ day.dayNumber }}</div>
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
              'py-2.5 sm:py-2.5 px-2 sm:px-2 rounded-lg border-2 text-center text-[11px] sm:text-xs md:text-sm font-semibold transition-all',
              selectedSlot?.start_at === slot.start_at
                ? 'border-brand-600 bg-gradient-to-br from-brand-50 to-brand-100/50 text-brand-700 shadow-md'
                : 'border-neutral-200 bg-white text-neutral-900 hover:border-brand-400 hover:shadow-sm',
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
import { useFormatters } from "@/composables/useFormatters";

const { formatTime } = useFormatters();

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
  return formatTime(dateString, props.professionalTimezone);
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
