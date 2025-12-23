<template>
  <div class="w-full mx-auto -mt-4 space-y-3 sm:space-y-4 pointer-events-none">
    <div
      class="rounded-lg sm:rounded-xl p-2 sm:p-3 bg-neutral-100 border border-neutral-400 flex items-center justify-between gap-2 sm:gap-3"
    >
      <div class="flex items-center min-w-0 flex-1">
        <Link2 class="mx-3 w-4 h-4 text-brand-500 flex-shrink-0" />
        <code class="text-sm text-neutral-900 font-mono font-semibold truncate">
          synkron.app/julien-martin
        </code>
      </div>
      <button
        class="px-2 sm:px-3 py-1 sm:py-1.5 bg-neutral-100 text-neutral-900 text-xs font-semibold rounded-md hover:bg-neutral-400 transition-colors flex justify-center items-center gap-1 sm:gap-1.5 flex-shrink-0"
      >
        <Copy class="w-3 h-3 sm:w-3.5 sm:h-3.5" />
        <span class="hidden sm:inline">Copier</span>
      </button>
    </div>

    <div class="grid grid-cols-2 gap-2 sm:gap-3">
      <div
        class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-100 border border-neutral-400 flex flex-col"
      >
        <div class="flex items-start justify-between mb-2 sm:mb-3 gap-2">
          <p
            class="text-xs sm:text-sm font-semibold text-neutral-700 leading-tight"
          >
            Rendez-vous confirmés
          </p>
          <CheckCircle
            class="w-4 h-4 sm:w-5 sm:h-5 text-success-500 flex-shrink-0 mt-0.5"
          />
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1">5</p>
        <p class="text-xs text-neutral-600 mt-auto">ce mois-ci</p>
      </div>

      <div
        class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-100 border border-neutral-400 flex flex-col"
      >
        <div class="flex items-start justify-between mb-2 sm:mb-3 gap-2">
          <p
            class="text-xs sm:text-sm font-semibold text-neutral-700 leading-tight"
          >
            Revenu prévu
          </p>
          <DollarSign
            class="w-4 h-4 sm:w-5 sm:h-5 text-brand-500 flex-shrink-0 mt-0.5"
          />
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-neutral-900 mb-1">385€</p>
        <p class="text-xs text-neutral-600 mt-auto">ce mois-ci</p>
      </div>
    </div>

    <div
      class="rounded-lg sm:rounded-xl p-3 sm:p-4 bg-neutral-100 border border-neutral-400"
    >
      <div class="flex items-center justify-between mb-2 sm:mb-3">
        <div class="flex items-center gap-1.5 sm:gap-2">
          <h2 class="text-sm sm:text-base font-semibold text-neutral-900">
            Réservations
          </h2>
          <PendingBookingsBadge
            :pending-count="2"
            icon-size="sm"
            @show-pending-modal="showPendingModal = true"
          />
        </div>
        <Calendar
          class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-neutral-600 flex-shrink-0"
        />
      </div>

      <div>
        <div>
          <div
            class="capitalize text-xs font-semibold text-neutral-700 mb-1.5 sm:mb-2"
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
                  'bg-brand-500 text-white font-semibold rounded-md sm:rounded-lg',
                day.hasBooking &&
                  !day.isToday &&
                  'bg-brand-200 text-brand-700 font-semibold rounded-md sm:rounded-lg',
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
import PendingBookingsBadge from "../dashboard/PendingBookingsBadge.vue";

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
