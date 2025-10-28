<template>
  <div class="contents">
    <template v-if="isLoading">
      <div
        v-for="i in 2"
        :key="i"
        class="bg-neutral-200 rounded-xl border border-neutral-400 p-4 space-y-3"
      >
        <div class="flex items-start gap-3">
          <div
            class="w-10 h-10 bg-neutral-300 rounded-full animate-pulse"
          ></div>
          <div class="flex-1 space-y-2">
            <div class="h-3 bg-neutral-300 rounded w-32 animate-pulse"></div>
            <div class="h-6 bg-neutral-300 rounded w-12 animate-pulse"></div>
            <div class="h-2.5 bg-neutral-300 rounded w-24 animate-pulse"></div>
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <StatBadge
        label="Rendez-vous confirmés"
        sublabel="ce mois-ci"
        :value="stats.upcoming_confirmed_bookings || 0"
        icon-component="CheckCircle"
        icon-color="text-emerald-500"
        bg-class="bg-neutral-200 border border-neutral-400"
        label-color="text-neutral-700"
        sublabel-color="text-neutral-600"
      />
      <StatBadge
        label="Revenu prévu"
        :value="`${stats.revenue_this_month}€`"
        sublabel="en décembre"
        icon-component="DollarSign"
        icon-color="text-blue-500"
        bg-class="bg-neutral-200 border border-neutral-400"
        label-color="text-neutral-700"
        sublabel-color="text-neutral-600"
      />
    </template>
  </div>
</template>

<script setup>
import StatBadge from "./StatBadge.vue";

defineProps({
  stats: {
    type: Object,
    required: true,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
});
</script>
