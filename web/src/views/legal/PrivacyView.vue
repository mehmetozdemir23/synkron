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

        <div class="prose prose-neutral max-w-none">
          <h2>1. Introduction</h2>
          <p>
            Synkron ("<strong>nous</strong>", "<strong>notre</strong>",
            "<strong>nos</strong>") s'engage à protéger et à respecter votre vie
            privée. Cette politique de confidentialité explique comment nous
            collectons, utilisons et partageons vos informations personnelles
            lorsque vous utilisez notre plateforme de réservation.
          </p>

          <h2>2. Données collectées</h2>
          <p>Nous collectons les types de données suivants :</p>
          <h3>2.1 Informations que vous nous fournissez</h3>
          <ul>
            <li>
              <strong>Compte professionnel</strong> : nom, email, mot de passe,
              nom d'entreprise, activité, fuseau horaire
            </li>
            <li><strong>Services</strong> : nom du service, durée, prix</li>
            <li>
              <strong>Disponibilités</strong> : horaires de travail par jour de
              la semaine
            </li>
            <li>
              <strong>Réservations</strong> : nom du client, email du client,
              date et heure de réservation
            </li>
          </ul>

          <h3>2.2 Informations de paiement</h3>
          <p>
            Les informations de paiement (carte bancaire) sont traitées par
            notre prestataire de paiement Stripe. Nous ne stockons jamais vos
            informations de carte bancaire complètes.
          </p>

          <h3>2.3 Données techniques</h3>
          <ul>
            <li>Adresse IP</li>
            <li>Type de navigateur</li>
            <li>Pages visitées</li>
            <li>Horodatage des connexions</li>
          </ul>

          <h2>3. Utilisation des données</h2>
          <p>Nous utilisons vos données pour :</p>
          <ul>
            <li>Créer et gérer votre compte</li>
            <li>Traiter les réservations</li>
            <li>Envoyer des emails de confirmation et d'annulation</li>
            <li>Traiter les paiements via Stripe</li>
            <li>Améliorer nos services</li>
            <li>Assurer la sécurité de la plateforme</li>
            <li>Respecter nos obligations légales</li>
          </ul>

          <h2>4. Partage des données</h2>
          <p>
            Nous ne vendons jamais vos données personnelles. Nous pouvons
            partager vos données avec :
          </p>
          <ul>
            <li><strong>Stripe</strong> : pour le traitement des paiements</li>
            <li>
              <strong>Prestataires d'email</strong> : pour l'envoi de
              notifications
            </li>
            <li><strong>Autorités légales</strong> : si requis par la loi</li>
          </ul>

          <h2>5. Conservation des données</h2>
          <p>
            Nous conservons vos données personnelles aussi longtemps que votre
            compte est actif ou que cela est nécessaire pour vous fournir nos
            services. Vous pouvez demander la suppression de votre compte à tout
            moment.
          </p>

          <h2>6. Vos droits (RGPD)</h2>
          <p>Conformément au RGPD, vous disposez des droits suivants :</p>
          <ul>
            <li>
              <strong>Droit d'accès</strong> : obtenir une copie de vos données
            </li>
            <li>
              <strong>Droit de rectification</strong> : corriger vos données
              inexactes
            </li>
            <li>
              <strong>Droit à l'effacement</strong> : supprimer vos données
            </li>
            <li>
              <strong>Droit à la portabilité</strong> : recevoir vos données
              dans un format structuré
            </li>
            <li>
              <strong>Droit d'opposition</strong> : s'opposer au traitement de
              vos données
            </li>
            <li>
              <strong>Droit de limitation</strong> : limiter le traitement de
              vos données
            </li>
          </ul>
          <p>
            Pour exercer ces droits, contactez-nous à l'adresse :
            <strong>privacy@synkron.com</strong>
          </p>

          <h2>7. Sécurité</h2>
          <p>
            Nous mettons en œuvre des mesures de sécurité techniques et
            organisationnelles appropriées pour protéger vos données contre tout
            accès, modification, divulgation ou destruction non autorisés.
          </p>

          <h2>8. Cookies</h2>
          <p>
            Nous utilisons des cookies essentiels pour le fonctionnement de la
            plateforme (authentification, session). Vous pouvez configurer votre
            navigateur pour refuser les cookies, mais certaines fonctionnalités
            peuvent ne pas fonctionner correctement.
          </p>

          <h2>9. Modifications</h2>
          <p>
            Nous pouvons modifier cette politique de confidentialité à tout
            moment. Les modifications seront publiées sur cette page avec une
            nouvelle date de mise à jour.
          </p>

          <h2>10. Contact</h2>
          <p>
            Pour toute question concernant cette politique de confidentialité,
            contactez-nous à :
          </p>
          <ul>
            <li><strong>Email</strong> : privacy@synkron.com</li>
            <li><strong>Adresse</strong> : [Votre adresse]</li>
          </ul>
        </div>

        <div class="mt-10 pt-8 border-t border-neutral-200 flex items-center justify-between">
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

const lastUpdate = computed(() => {
  const date = new Date();
  return date.toLocaleDateString("fr-FR", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
});
</script>

<style scoped>
.prose h2 {
  @apply text-2xl font-bold text-neutral-900 mt-10 mb-4 first:mt-0;
}

.prose h3 {
  @apply text-lg font-semibold text-neutral-900 mt-6 mb-3;
}

.prose p {
  @apply text-neutral-600 mb-4 leading-relaxed text-base;
}

.prose ul {
  @apply list-disc pl-6 mb-4 space-y-2;
}

.prose ul li {
  @apply text-neutral-600 text-base;
}

.prose strong {
  @apply font-semibold text-neutral-900;
}
</style>
