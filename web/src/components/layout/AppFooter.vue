<template>
  <footer
    class="border-t border-neutral-200 bg-neutral-100 py-10 sm:py-12 px-4 sm:px-6 flex-shrink-0"
  >
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div>
          <LogoBrand size="sm" class="mb-5" />
          <p class="text-sm text-neutral-600 leading-relaxed font-medium">
            Simplifiez la gestion de vos rendez-vous professionnels.
          </p>
        </div>
        <div>
          <h4 class="font-semibold text-neutral-900 mb-4 text-sm">Contact</h4>
          <ul class="space-y-2 text-sm text-neutral-600">
            <li>
              <a
                href="mailto:contact@synkron.app"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >contact@synkron.app</a
              >
            </li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-neutral-900 mb-4 text-sm">Légal</h4>
          <ul class="space-y-2 text-sm text-neutral-600">
            <li>
              <router-link
                to="/privacy"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Confidentialité</router-link
              >
            </li>
            <li>
              <router-link
                to="/terms"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Conditions</router-link
              >
            </li>
          </ul>
        </div>
      </div>

      <div
        class="border-t border-neutral-200 pt-8 text-center text-sm text-neutral-600 font-medium"
      >
        <p>© 2025 Synkron. Tous droits réservés.</p>
      </div>
    </div>
  </footer>
</template>
<script setup>
import LogoBrand from "@/components/layout/LogoBrand.vue";
</script>
