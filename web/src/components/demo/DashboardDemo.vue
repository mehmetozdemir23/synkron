<template>
  <div class="w-full space-y-6 pointer-events-none">
    <div class="flex justify-between items-center gap-3 min-w-0">
      <Link2 class="w-4 h-4 text-neutral-600 flex-shrink-0" />
      <code class="text-xs sm:text-sm text-neutral-950 font-mono truncate">
        synkron.app/julien-martin
      </code>
      <button
        class="py-2 px-4 rounded-lg font-medium text-xs flex justify-center items-center gap-1.5 whitespace-nowrap flex-shrink-0 bg-brand-500 text-white"
      >
        <Copy class="w-3.5 h-3.5" />
        <span class="hidden sm:inline">Copier le lien</span>
      </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="rounded-xl p-5 sm:p-6 bg-neutral-200 border border-neutral-400">
        <div class="flex items-center justify-between mb-3">
          <p class="text-sm font-medium text-neutral-700">
            Rendez-vous confirmés
          </p>
          <CheckCircle class="w-5 h-5 text-emerald-500" />
        </div>
        <p class="text-3xl sm:text-4xl font-bold text-neutral-950">5</p>
        <p class="text-xs mt-2 text-neutral-600">ce mois-ci</p>
      </div>

      <div class="rounded-xl p-5 sm:p-6 bg-neutral-200 border border-neutral-400">
        <div class="flex items-center justify-between mb-3">
          <p class="text-sm font-medium text-neutral-700">Revenu prévu</p>
          <DollarSign class="w-5 h-5 text-blue-500" />
        </div>
        <p class="text-3xl sm:text-4xl font-bold text-neutral-950">385€</p>
        <p class="text-xs mt-2 text-neutral-600">en décembre</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link2, Copy, CheckCircle, DollarSign } from "lucide-vue-next";
</script>
