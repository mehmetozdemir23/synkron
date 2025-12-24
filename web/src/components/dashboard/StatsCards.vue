<template>
  <div class="contents">
    <template v-if="isLoading">
      <div
        v-for="i in 2"
        :key="i"
        class="bg-white rounded-xl border border-neutral-200 p-5 space-y-3"
      >
        <div class="flex items-start gap-3">
          <div
            class="w-10 h-10 bg-neutral-200 rounded-full animate-pulse"
          ></div>
          <div class="flex-1 space-y-2">
            <div class="h-3 bg-neutral-200 rounded w-32 animate-pulse"></div>
            <div class="h-6 bg-neutral-200 rounded w-12 animate-pulse"></div>
            <div class="h-2.5 bg-neutral-200 rounded w-24 animate-pulse"></div>
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <StatCard
        label="Rendez-vous confirmés"
        sublabel="ce mois-ci"
        :value="stats.upcoming_confirmed_bookings || 0"
        icon-component="CheckCircle"
        icon-color="text-success-500"
        label-color="text-neutral-700"
        sublabel-color="text-neutral-600"
      />
      <StatCard
        label="Revenu prévu"
        :value="`${stats.revenue_this_month}€`"
        sublabel="ce mois-ci"
        icon-component="DollarSign"
        icon-color="text-brand-500"
        label-color="text-neutral-700"
        sublabel-color="text-neutral-600"
      />
    </template>
  </div>
</template>

<script setup>
import StatCard from "./StatCard.vue";

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
