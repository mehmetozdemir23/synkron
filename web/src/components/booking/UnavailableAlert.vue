<template>
  <div class="bg-warning-100 border border-warning-400 rounded-xl p-4 text-center">
    <AlertCircle class="w-8 h-8 text-warning-500 mx-auto mb-2" />
    <h2 class="text-base font-semibold text-neutral-950 mb-0.5">
      Actuellement indisponible
    </h2>
    <p class="text-xs text-neutral-800">
      Les réservations ne sont pas disponibles pour le moment.
    </p>
  </div>
</template>

<script setup>
import { AlertCircle } from "lucide-vue-next";
</script>
