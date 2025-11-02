<template>
  <div class="relative flex-1 min-w-[64px] max-w-[96px]">
    <button
      @click="toggleMenu"
      class="bottom-nav-item group flex flex-col items-center justify-center gap-1 px-1 py-2 transition-all duration-200 w-full"
    >
      <div
        :class="[
          'relative flex items-center justify-center w-16 h-8 rounded-full transition-all duration-200',
          isOpen
            ? 'bg-brand-100'
            : 'group-hover:bg-neutral-200/50 group-active:bg-neutral-200',
        ]"
      >
        <MoreVertical
          :class="[
            'w-6 h-6 transition-all duration-200',
            isOpen ? 'text-brand-700' : 'text-neutral-700 group-hover:text-neutral-900',
          ]"
        />
      </div>
      <span
        :class="[
          'text-[11px] font-medium transition-all duration-200 leading-none text-center px-1',
          isOpen ? 'text-neutral-900' : 'text-neutral-700',
        ]"
      >
        Plus
      </span>
    </button>

    <Transition
      enter-active-class="transition-opacity duration-200 ease-out"
      leave-active-class="transition-opacity duration-150 ease-in"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        @click="closeMenu"
        class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40"
      ></div>
    </Transition>

    <Transition
      enter-active-class="transition-all duration-200 ease-out"
      leave-active-class="transition-all duration-150 ease-in"
      enter-from-class="opacity-0 translate-y-2 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-2 scale-95"
    >
      <div
        v-if="isOpen"
        class="fixed right-2 flex flex-col rounded-2xl shadow-lg bg-neutral-100 border border-neutral-400 w-52 z-50 overflow-hidden"
        :style="{ bottom: 'calc(4.5rem + env(safe-area-inset-bottom))' }"
      >
        <router-link
          to="/dashboard/profile"
          class="flex items-center gap-3 px-4 py-3.5 text-sm font-medium text-neutral-900 hover:bg-neutral-200 active:bg-neutral-300 border-b border-neutral-300 transition-colors"
          @click="closeMenu"
        >
          <div class="w-9 h-9 rounded-lg bg-neutral-200 flex items-center justify-center">
            <Settings class="w-4 h-4 text-neutral-700" />
          </div>
          <span>Profil</span>
        </router-link>

        <button
          @click="handleLogout"
          class="flex items-center gap-3 w-full px-4 py-3.5 text-sm font-medium text-error-700 hover:bg-error-50 active:bg-error-100 transition-colors cursor-pointer text-left"
        >
          <div class="w-9 h-9 rounded-lg bg-error-50 flex items-center justify-center">
            <LogOutIcon class="w-4 h-4 text-error-600" />
          </div>
          <span>Déconnexion</span>
        </button>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { MoreVertical, Settings, LogOut as LogOutIcon } from "lucide-vue-next";

const router = useRouter();
const authStore = useAuthStore();
const isOpen = ref(false);

function toggleMenu() {
  isOpen.value = !isOpen.value;
}

function closeMenu() {
  isOpen.value = false;
}

async function handleLogout() {
  await authStore.logout();
  router.push("/login");
  closeMenu();
}
</script>
