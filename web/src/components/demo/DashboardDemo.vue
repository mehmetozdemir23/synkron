<template>
  <div class="w-full mx-auto space-y-3 sm:space-y-4 pointer-events-none">
    <div
      class="rounded-lg sm:rounded-xl p-2 sm:p-3 bg-neutral-200 border border-neutral-400 flex items-center justify-between gap-2 sm:gap-3"
    >
      <div class="flex items-center min-w-0 flex-1">
        <Link2 class="mx-3 w-4 h-4 text-brand-500 flex-shrink-0" />
        <code class="text-sm text-neutral-950 font-mono truncate">
          synkron.app/julien-martin
        </code>
      </div>
      <button
        class="px-2 sm:px-3 py-1 sm:py-1.5 bg-neutral-300 text-neutral-800 text-xs font-medium rounded-md hover:bg-neutral-400 transition-colors flex justify-center items-center gap-1 sm:gap-1.5 flex-shrink-0"
      >
        <Copy class="w-3 h-3 sm:w-3.5 sm:h-3.5" />
        <span class="hidden sm:inline">Copier</span>
      </button>
    </div>

    <div class="grid grid-cols-2 gap-2 sm:gap-3">
      <div
        class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-200 border border-neutral-400"
      >
        <div class="flex items-center justify-between mb-1.5 sm:mb-2">
          <p class="text-xs sm:text-sm font-medium text-neutral-700">
            Rendez-vous confirmés
          </p>
          <CheckCircle
            class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-500 flex-shrink-0"
          />
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-neutral-950">5</p>
        <p class="text-xs mt-1 text-neutral-600">ce mois-ci</p>
      </div>

      <div
        class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-200 border border-neutral-400"
      >
        <div class="flex items-center justify-between mb-1.5 sm:mb-2">
          <p class="text-xs sm:text-sm font-medium text-neutral-700">
            Revenu prévu
          </p>
          <DollarSign
            class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500 flex-shrink-0"
          />
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-neutral-950">385€</p>
        <p class="text-xs mt-1 text-neutral-600">ce mois-ci</p>
      </div>
    </div>

    <div
      class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-200 border border-neutral-400"
    >
      <div class="flex items-center justify-between mb-2 sm:mb-3">
        <div class="flex items-center gap-1.5 sm:gap-2">
          <h2 class="text-sm sm:text-base font-semibold text-neutral-900">
            Réservations
          </h2>
          <div
            class="px-1.5 sm:px-2 py-0.5 mb-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-900 border border-amber-300 flex items-center gap-1"
          >
            <div
              class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-amber-500"
            ></div>
            <span class="text-[10px] sm:text-xs">2 en attente</span>
          </div>
        </div>
        <Calendar
          class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-neutral-600 flex-shrink-0"
        />
      </div>

      <div>
        <div>
          <div
            class="capitalize text-xs font-semibold text-neutral-600 mb-1.5 sm:mb-2"
          >
            {{ currentDate }}
          </div>
          <div
            class="grid grid-cols-7 gap-1 sm:gap-1.5 text-center text-[10px] sm:text-xs font-semibold text-neutral-600 mb-1 sm:mb-1.5"
          >
            <div>L</div>
            <div>M</div>
            <div>M</div>
            <div>J</div>
            <div>V</div>
            <div>S</div>
            <div>D</div>
          </div>

          <div
            class="grid grid-cols-7 gap-1 sm:gap-1.5 text-center text-xs sm:text-sm"
          >
            <div
              v-for="(day, index) in calendarDays"
              :key="index"
              :class="[
                'py-1',
                day.isCurrentMonth ? 'text-neutral-700' : 'text-neutral-500',
                day.isToday &&
                  'bg-brand-500 text-white font-bold rounded-md sm:rounded-lg shadow-sm',
                day.hasBooking &&
                  !day.isToday &&
                  'bg-brand-100 text-brand-700 font-semibold rounded-md sm:rounded-lg',
              ]"
            >
              {{ day.day }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import {
  CheckCircle,
  DollarSign,
  Calendar,
  Link2,
  Copy,
} from "lucide-vue-next";

const now = new Date();
const currentDate = new Intl.DateTimeFormat("fr-FR", {
  month: "long",
  year: "numeric",
}).format(now);

const calendarDays = computed(() => {
  const year = now.getFullYear();
  const month = now.getMonth();
  const today = now.getDate();

  const firstDay = new Date(year, month, 1);
  const firstDayOfWeek = firstDay.getDay();

  const startOffset = firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1;

  const lastDay = new Date(year, month + 1, 0);
  const daysInMonth = lastDay.getDate();

  const prevMonthLastDay = new Date(year, month, 0).getDate();

  const bookingDays = [12, 18, 20];

  const days = [];

  for (let i = startOffset - 1; i >= 0; i--) {
    days.push({
      day: prevMonthLastDay - i,
      isCurrentMonth: false,
      isToday: false,
      hasBooking: false,
    });
  }

  for (let day = 1; day <= daysInMonth; day++) {
    days.push({
      day,
      isCurrentMonth: true,
      isToday: day === today,
      hasBooking: bookingDays.includes(day),
    });
  }

  const remainingDays = 42 - days.length;
  for (let day = 1; day <= remainingDays; day++) {
    days.push({
      day,
      isCurrentMonth: false,
      isToday: false,
      hasBooking: false,
    });
  }

  return days;
});
</script>
