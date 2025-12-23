<template>
  <div class="min-h-screen bg-neutral-50">
    <aside
      class="hidden lg:flex fixed left-0 top-0 h-screen w-20 flex-col z-40 shadow-sm"
    >
      <router-link
        to="/dashboard"
        class="flex items-center justify-center h-20 pt-2"
      >
        <img src="@/assets/logo-simple.svg" alt="Synkron" class="w-auto h-8" />
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

      <div class="px-2.5 pb-2.5 relative">
        <button
          @click="showUserMenu = !showUserMenu"
          aria-label="Menu utilisateur"
          :aria-expanded="showUserMenu"
          class="flex flex-col items-center justify-center gap-1 py-1.5 w-full group"
          :title="userDisplayName"
        >
          <div
            class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 text-white font-semibold text-base group-hover:shadow-md transition-all"
          >
            {{ userInitials }}
          </div>
          <span
            class="text-xs font-medium text-neutral-700 truncate w-full px-1 text-center"
          >
            {{ userFirstName }}
          </span>
        </button>

        <Transition
          enter-active-class="transition ease-out duration-100"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div
            v-if="showUserMenu"
            class="absolute bottom-full left-4 mb-2 w-48 bg-neutral-100 rounded-xl shadow-xl border border-neutral-300 overflow-hidden z-50"
          >
            <div class="p-3 border-b border-neutral-300 bg-neutral-200">
              <p class="text-sm font-semibold text-neutral-950 truncate">
                {{ userDisplayName }}
              </p>
              <p class="text-xs text-neutral-700 truncate mt-0.5">
                {{ authStore.user?.email }}
              </p>
            </div>

            <div class="py-1 bg-neutral-100">
              <router-link
                to="/dashboard/profile"
                @click="showUserMenu = false"
                class="flex items-center gap-2 px-3 py-2.5 text-sm text-neutral-900 hover:bg-neutral-200 transition-colors"
              >
                <User class="w-4 h-4" />
                <span class="font-medium">Mon profil</span>
              </router-link>

              <button
                @click="handleLogout"
                class="w-full flex items-center gap-2 px-3 py-2.5 text-sm text-error-600 hover:bg-error-50 transition-colors"
              >
                <LogOut class="w-4 h-4" />
                <span class="font-medium">Déconnexion</span>
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </aside>

    <main class="lg:ml-20 h-screen flex flex-col pb-20 lg:pb-0">
      <div
        class="lg:hidden flex-shrink-0 bg-neutral-100 px-4 py-3 flex items-center justify-center shadow-md"
      >
        <LogoBrand size="sm" />
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
      class="lg:hidden fixed bottom-0 left-0 right-0 bg-neutral-100 z-50 safe-area-inset-bottom shadow-lg"
    >
      <div
        class="flex items-center justify-around h-20 px-2 py-2 gap-1 relative"
      >
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

        <button
          @click="showUserMenuMobile = !showUserMenuMobile"
          aria-label="Menu utilisateur"
          :aria-expanded="showUserMenuMobile"
          class="flex flex-col items-center justify-center gap-1 py-2 px-3 rounded-lg hover:bg-neutral-200 transition-colors"
        >
          <div
            class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 text-white font-semibold text-xs"
          >
            {{ userInitials }}
          </div>
          <span class="text-xs font-medium text-neutral-700 truncate">
            Profil
          </span>
        </button>

        <Transition
          enter-active-class="transition ease-out duration-100"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div
            v-if="showUserMenuMobile"
            class="absolute bottom-full right-4 mb-2 w-56 bg-neutral-100 rounded-xl shadow-xl border border-neutral-300 overflow-hidden z-50"
          >
            <div class="p-3 border-b border-neutral-300 bg-neutral-200">
              <p class="text-sm font-semibold text-neutral-950 truncate">
                {{ userDisplayName }}
              </p>
              <p class="text-xs text-neutral-700 truncate mt-0.5">
                {{ authStore.user?.email }}
              </p>
            </div>

            <div class="py-1 bg-neutral-100">
              <router-link
                to="/dashboard/profile"
                @click="showUserMenuMobile = false"
                class="flex items-center gap-2 px-3 py-2.5 text-sm text-neutral-900 hover:bg-neutral-200 transition-colors"
              >
                <User class="w-4 h-4" />
                <span class="font-medium">Mon profil</span>
              </router-link>

              <button
                @click="handleLogout"
                class="w-full flex items-center gap-2 px-3 py-2.5 text-sm text-error-600 hover:bg-error-50 transition-colors"
              >
                <LogOut class="w-4 h-4" />
                <span class="font-medium">Déconnexion</span>
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import LogoBrand from "@/components/layout/LogoBrand.vue";
import NavRailItem from "@/components/layout/NavRailItem.vue";
import MobileNavItem from "@/components/layout/MobileNavItem.vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import {
  LayoutDashboard,
  Briefcase,
  CalendarDays,
  User,
  LogOut,
} from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const showUserMenu = ref(false);
const showUserMenuMobile = ref(false);

const userDisplayName = computed(() => {
  if (!authStore.user) return "";
  return (
    authStore.user.business_name ||
    `${authStore.user.firstname} ${authStore.user.lastname}`.trim()
  );
});

const userFirstName = computed(() => {
  if (!authStore.user) return "";
  return (
    authStore.user.firstname ||
    authStore.user.business_name?.split(" ")[0] ||
    "User"
  );
});

const userInitials = computed(() => {
  if (!authStore.user) return "?";

  const firstname = authStore.user.firstname || "";
  const lastname = authStore.user.lastname || "";
  return `${firstname[0] || ""}${lastname[0] || ""}`.toUpperCase() || "U";
});

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
];

async function handleLogout() {
  showUserMenu.value = false;
  showUserMenuMobile.value = false;
  await authStore.logout();
  router.push("/login");
}

function handleClickOutside(event) {
  const menuDesktop = document.querySelector(".absolute.bottom-full.left-4");
  const buttonDesktop = document.querySelector("button[title]");
  const menuMobile = document.querySelector(".absolute.bottom-full.right-4");
  const buttonMobile = event.target.closest("button");

  if (showUserMenu.value && menuDesktop && buttonDesktop) {
    if (
      !menuDesktop.contains(event.target) &&
      !buttonDesktop.contains(event.target)
    ) {
      showUserMenu.value = false;
    }
  }

  if (showUserMenuMobile.value && menuMobile) {
    if (
      !menuMobile.contains(event.target) &&
      buttonMobile?.textContent?.includes("Profil")
    ) {
      return;
    }
    if (!menuMobile.contains(event.target)) {
      showUserMenuMobile.value = false;
    }
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
