<template>
  <div class="flex flex-col min-h-screen bg-gray-50">
    <RouterView />
    <ToastContainer />
  </div>
</template>
<script setup>
import { RouterView } from "vue-router";
import ToastContainer from "@/components/ui/ToastContainer.vue";
</script>
