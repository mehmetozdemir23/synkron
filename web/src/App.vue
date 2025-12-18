<template>
  <div class="flex flex-col min-h-screen bg-gray-50">
    <RouterView />
    <ToastContainer />
    <AlertModal />
  </div>
</template>
<script setup>
import { RouterView } from "vue-router";
import ToastContainer from "@/components/ui/ToastContainer.vue";
import AlertModal from "@/components/ui/AlertModal.vue";
</script>
