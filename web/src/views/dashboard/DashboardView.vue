<template>
  <DashboardLayout>
    <template #header>
      <div
        class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4"
      >
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-normal text-neutral-900">
            Bonjour, {{ authStore.user?.firstname }}
          </h1>
        </div>
        <div class="flex-shrink-0">
          <ShareLink :url="publicUrl" />
        </div>
      </div>
    </template>

    <div class="w-full space-y-6">
      <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <StatsBadges :stats="stats" :is-loading="isLoadingStats" />
        </div>
      </section>

      <section>
        <BookingsSection
          :bookings="bookings"
          :is-loading="isLoading"
          @refresh="refreshDashboard"
        />
      </section>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useStatsStore } from "@/stores/stats";
import { useBookingsStore } from "@/stores/bookings";
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import StatsBadges from "@/components/dashboard/StatsBadges.vue";
import BookingsSection from "@/components/dashboard/BookingsSection.vue";
import ShareLink from "@/components/dashboard/ShareLink.vue";

const authStore = useAuthStore();
const statsStore = useStatsStore();
const bookingsStore = useBookingsStore();

const stats = computed(() => statsStore.stats);
const bookings = computed(() => bookingsStore.bookings);
const isLoadingStats = computed(() => statsStore.loading);
const isLoading = computed(() => statsStore.loading || bookingsStore.loading);

const publicUrl = computed(() => {
  const baseUrl = window.location.origin;
  return `${baseUrl}/${authStore.user?.slug}`;
});

onMounted(async () => {
  const now = new Date();
  await Promise.all([
    statsStore.fetch(),
    bookingsStore.fetchAll({
      month: now.getMonth() + 1,
      year: now.getFullYear(),
    }),
  ]);
});

async function refreshDashboard() {
  const now = new Date();
  await Promise.all([
    statsStore.fetch(true),
    bookingsStore.fetchAll(
      {
        month: now.getMonth() + 1,
        year: now.getFullYear(),
      },
      { force: true }
    ),
  ]);
}
</script>
