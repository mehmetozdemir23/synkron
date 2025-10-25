<template>
  <div class="min-h-screen bg-neutral-50">
    <aside
      class="hidden lg:flex fixed left-0 top-0 h-screen w-20 bg-neutral-100 flex-col z-40 border-r border-neutral-400"
    >
      <router-link
        to="/dashboard"
        class="flex items-center justify-center h-20 pt-2 transition-transform hover:scale-105 duration-200"
      >
        <img src="@/assets/logo-simple.svg" alt="Synkron" class="w-10 h-10" />
      </router-link>

      <nav class="flex-1 px-2.5 py-2 space-y-0.5">
        <NavRailItem
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          :icon="item.icon"
          :label="item.label"
          :title="item.title"
        />
      </nav>

      <div class="px-2.5 pb-2.5">
        <button
          @click="handleLogout"
          class="flex flex-col items-center justify-center gap-0.5 py-1.5 text-neutral-600 w-full rounded-2xl hover:text-neutral-800 hover:bg-neutral-200 border-0 cursor-pointer bg-transparent transition-colors"
          title="Déconnexion"
        >
          <div class="flex items-center justify-center w-12 h-12 rounded-full">
            <LogOut class="w-5 h-5" />
          </div>
          <span class="text-xs font-medium">Quitter</span>
        </button>
      </div>
    </aside>

    <main class="lg:ml-20 h-screen flex flex-col pb-20 lg:pb-0">
      <div
        class="lg:hidden flex-shrink-0 bg-neutral-100/95 backdrop-blur-md border-b border-neutral-400 px-4 py-3"
      >
        <LogoBrand size="md" />
      </div>

      <div class="flex-1 overflow-y-auto">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="pt-7 pb-6">
            <slot name="header" />
          </div>
          <div class="pb-6 lg:pb-8">
            <slot />
          </div>
        </div>
      </div>
    </main>

    <nav
      class="lg:hidden fixed bottom-0 left-0 right-0 bg-neutral-100/98 backdrop-blur-lg border-t border-neutral-300 z-50 safe-area-inset-bottom shadow-[0_-2px_8px_rgba(0,0,0,0.04)]"
    >
      <div class="flex items-center justify-around h-20 px-2 py-2 gap-1">
        <MobileNavItem
          to="/dashboard"
          :icon="LayoutDashboard"
          label="Accueil"
        />

        <MobileNavItem
          to="/dashboard/services"
          :icon="Briefcase"
          label="Services"
        />

        <MobileNavItem
          to="/dashboard/availabilities"
          :icon="CalendarDays"
          label="Horaires"
        />

        <MobileNavMenu label="Plus" />
      </div>
    </nav>
  </div>
</template>

<script setup>
import LogoBrand from "@/components/layout/LogoBrand.vue";
import NavRailItem from "@/components/layout/NavRailItem.vue";
import MobileNavItem from "@/components/layout/MobileNavItem.vue";
import MobileNavMenu from "@/components/layout/MobileNavMenu.vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import {
  LayoutDashboard,
  Briefcase,
  CalendarDays,
  Settings,
  LogOut,
} from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();

const navItems = [
  {
    path: "/dashboard",
    icon: LayoutDashboard,
    label: "Accueil",
    title: "Tableau de bord",
  },
  {
    path: "/dashboard/services",
    icon: Briefcase,
    label: "Services",
    title: "Services",
  },
  {
    path: "/dashboard/availabilities",
    icon: CalendarDays,
    label: "Horaires",
    title: "Disponibilités",
  },
  {
    path: "/dashboard/profile",
    icon: Settings,
    label: "Profil",
    title: "Profil",
  },
];

async function handleLogout() {
  await authStore.logout();
  router.push("/login");
}
</script>
