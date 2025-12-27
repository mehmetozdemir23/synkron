<template>
  <div class="min-h-screen bg-neutral-50 flex flex-col">
    <PublicHeader />

    <div class="flex-1 max-w-4xl mx-auto w-full px-4 py-12 sm:py-16">
      <div class="bg-neutral-100 rounded-xl shadow-md p-8 sm:p-10 md:p-12">
        <div class="mb-8 pb-8 border-b border-neutral-300">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-3">
            Politique de confidentialité
          </h1>
          <p class="text-sm text-neutral-500">
            Dernière mise à jour : {{ lastUpdate }}
          </p>
        </div>

        <div class="space-y-8">
          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              1. Introduction
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Synkron ("<strong class="font-semibold text-neutral-900"
                >nous</strong
              >", "<strong class="font-semibold text-neutral-900"
                >notre</strong
              >", "<strong class="font-semibold text-neutral-900">nos</strong
              >") s'engage à protéger et à respecter votre vie privée. Cette
              politique de confidentialité explique comment nous collectons,
              utilisons et partageons vos informations personnelles lorsque vous
              utilisez notre plateforme de réservation.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              2. Données collectées
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Nous collectons les types de données suivants :
            </p>
            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              2.1 Informations que vous nous fournissons
            </h3>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Compte professionnel</strong
                >
                : nom, email, mot de passe, nom d'entreprise, activité, fuseau
                horaire
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900">Services</strong>
                : nom du service, durée, prix
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Disponibilités</strong
                >
                : horaires de travail par jour de la semaine
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Réservations</strong
                >
                : nom du client, email du client, date et heure de réservation
              </li>
            </ul>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              2.2 Informations de paiement
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Les informations de paiement (carte bancaire) sont traitées par
              notre prestataire de paiement Stripe. Nous ne stockons jamais vos
              informations de carte bancaire complètes.
            </p>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              2.3 Données techniques
            </h3>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">Adresse IP</li>
              <li class="text-neutral-600 text-sm sm:text-base">Type de navigateur</li>
              <li class="text-neutral-600 text-sm sm:text-base">Pages visitées</li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Horodatage des connexions
              </li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              3. Utilisation des données
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Nous utilisons vos données pour :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                Créer et gérer votre compte
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Traiter les réservations
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Envoyer des emails de confirmation et d'annulation
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Traiter les paiements via Stripe
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">Améliorer nos services</li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Assurer la sécurité de la plateforme
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Respecter nos obligations légales
              </li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              4. Partage des données
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Nous ne vendons jamais vos données personnelles. Nous pouvons
              partager vos données avec :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900">Stripe</strong> :
                pour le traitement des paiements
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Prestataires d'email</strong
                >
                : pour l'envoi de notifications
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Autorités légales</strong
                >
                : si requis par la loi
              </li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              5. Conservation des données
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous conservons vos données personnelles aussi longtemps que votre
              compte est actif ou que cela est nécessaire pour vous fournir nos
              services. Vous pouvez demander la suppression de votre compte à
              tout moment.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              6. Vos droits (RGPD)
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Conformément au RGPD, vous disposez des droits suivants :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit d'accès</strong
                >
                : obtenir une copie de vos données
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit de rectification</strong
                >
                : corriger vos données inexactes
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit à l'effacement</strong
                >
                : supprimer vos données
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit à la portabilité</strong
                >
                : recevoir vos données dans un format structuré
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit d'opposition</strong
                >
                : s'opposer au traitement de vos données
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Droit de limitation</strong
                >
                : limiter le traitement de vos données
              </li>
            </ul>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Pour exercer ces droits, contactez-nous à l'adresse :
              <strong class="font-semibold text-neutral-900"
                >privacy@synkron.com</strong
              >
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              7. Sécurité
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous mettons en œuvre des mesures de sécurité techniques et
              organisationnelles appropriées pour protéger vos données contre
              tout accès, modification, divulgation ou destruction non
              autorisés.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">8. Cookies</h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous utilisons des cookies essentiels pour le fonctionnement de la
              plateforme (authentification, session). Vous pouvez configurer
              votre navigateur pour refuser les cookies, mais certaines
              fonctionnalités peuvent ne pas fonctionner correctement.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              9. Modifications
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous pouvons modifier cette politique de confidentialité à tout
              moment. Les modifications seront publiées sur cette page avec une
              nouvelle date de mise à jour.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              10. Contact
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Pour toute question concernant cette politique de confidentialité,
              contactez-nous à :
            </p>
            <ul class="list-disc pl-6 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900">Email</strong> :
                contact@synkron.app
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900">Adresse</strong>
                : 69150 Décines-Charpieu
              </li>
            </ul>
          </section>
        </div>

        <div
          class="mt-10 pt-8 border-t border-neutral-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
        >
          <BaseButton @click="$router.go(-1)" variant="secondary">
            <ArrowLeft class="w-4 h-4" />
            Retour
          </BaseButton>
          <router-link
            to="/terms"
            class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
          >
            Voir les conditions d'utilisation →
          </router-link>
        </div>
      </div>
    </div>

    <AppFooter />
  </div>
</template>

<script setup>
import PublicHeader from "@/components/layout/PublicHeader.vue";
import AppFooter from "@/components/layout/AppFooter.vue";
import { computed } from "vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import { ArrowLeft } from "lucide-vue-next";

const lastUpdate = computed(() => {
  const date = new Date();
  return date.toLocaleDateString("fr-FR", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
});
</script>
