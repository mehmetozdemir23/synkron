<template>
  <div class="flex-1 p-6 space-y-6">
    <div class="space-y-4">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-neutral-200 rounded-full animate-pulse"></div>
        <div class="flex-1 space-y-2">
          <div class="h-6 bg-neutral-200 rounded w-48 animate-pulse"></div>
          <div class="h-4 bg-neutral-200 rounded w-32 animate-pulse"></div>
        </div>
      </div>
    </div>
    <div class="space-y-3">
      <div class="h-5 bg-neutral-200 rounded w-40 animate-pulse"></div>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <div v-for="i in 6" :key="i" class="h-20 bg-neutral-200 rounded-xl animate-pulse"></div>
      </div>
    </div>
  </div>
</template>
