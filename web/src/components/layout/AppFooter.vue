<template>
  <footer
    class="border-t border-neutral-400 bg-neutral-100 py-10 sm:py-12 px-4 sm:px-6 flex-shrink-0"
  >
    <div class="max-w-7xl mx-auto">
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-6 sm:mb-8"
      >
        <div>
          <LogoBrand size="sm" class="mb-5" />
          <p class="text-sm text-neutral-600 leading-relaxed font-medium">
            Votre agenda professionnel. Automatisé.
          </p>
        </div>
        <div>
          <h4 class="font-semibold text-neutral-900 mb-4 text-sm">Produit</h4>
          <ul class="space-y-2 text-sm text-neutral-600">
            <li>
              <a
                href="#"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Caractéristiques</a
              >
            </li>
            <li>
              <a
                href="#"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Tarifs</a
              >
            </li>
            <li>
              <a
                href="#"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Sécurité</a
              >
            </li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-neutral-900 mb-4 text-sm">
            Entreprise
          </h4>
          <ul class="space-y-2 text-sm text-neutral-600">
            <li>
              <a
                href="#"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >À propos</a
              >
            </li>
            <li>
              <a
                href="#"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Blog</a
              >
            </li>
            <li>
              <a
                href="mailto:contact@synkron.app"
                class="hover:text-neutral-900 transition-colors duration-200 font-medium"
                >Contact</a
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
        class="border-t border-neutral-400 pt-8 text-center text-sm text-neutral-600 font-medium"
      >
        <p>© 2025 Synkron. Tous droits réservés.</p>
      </div>
    </div>
  </footer>
</template>
<script setup>
import LogoBrand from "@/components/layout/LogoBrand.vue";
</script>
