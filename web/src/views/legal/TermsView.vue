<template>
  <div class="min-h-screen bg-neutral-50 flex flex-col">
    <PublicHeader />

    <div class="flex-1 max-w-4xl mx-auto w-full px-4 py-12 sm:py-16">
      <div class="bg-neutral-200 rounded-xl border border-neutral-400 p-8 sm:p-10 md:p-12 shadow-sm">
        <div class="mb-8 pb-8 border-b border-neutral-400">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-3">
            Conditions Générales d'Utilisation
          </h1>
          <p class="text-sm text-neutral-500">
            Dernière mise à jour : {{ lastUpdate }}
          </p>
        </div>

        <div class="prose prose-neutral max-w-none">
          <h2>1. Acceptation des conditions</h2>
          <p>
            En accédant et en utilisant Synkron ("<strong>la plateforme</strong
            >", "<strong>le service</strong>"), vous acceptez d'être lié par ces
            Conditions Générales d'Utilisation ("<strong>CGU</strong>"). Si vous
            n'acceptez pas ces conditions, veuillez ne pas utiliser la
            plateforme.
          </p>

          <h2>2. Description du service</h2>
          <p>
            Synkron est une plateforme SaaS permettant aux professionnels de
            gérer leurs disponibilités, leurs services et de recevoir des
            réservations en ligne de la part de leurs clients.
          </p>
          <p>Le service comprend :</p>
          <ul>
            <li>Gestion de profil professionnel</li>
            <li>Création et gestion de services</li>
            <li>Configuration des disponibilités</li>
            <li>Système de réservation en ligne</li>
            <li>Notifications par email</li>
            <li>Gestion des abonnements (gratuit et premium)</li>
          </ul>

          <h2>3. Inscription et compte</h2>
          <h3>3.1 Conditions d'inscription</h3>
          <p>Pour utiliser la plateforme, vous devez :</p>
          <ul>
            <li>Avoir au moins 18 ans</li>
            <li>Fournir des informations exactes et complètes</li>
            <li>Maintenir vos informations à jour</li>
            <li>
              Être responsable de la confidentialité de votre mot de passe
            </li>
          </ul>

          <h3>3.2 Responsabilité du compte</h3>
          <p>
            Vous êtes responsable de toutes les activités effectuées sous votre
            compte. Vous devez nous informer immédiatement de toute utilisation
            non autorisée de votre compte.
          </p>

          <h2>4. Abonnements et paiements</h2>
          <h3>4.1 Plans disponibles</h3>
          <ul>
            <li>
              <strong>Plan Gratuit</strong> : Limité à 10 réservations par mois
            </li>
            <li>
              <strong>Plan Pro</strong> : Réservations illimitées, moyennant un
              abonnement mensuel ou annuel
            </li>
          </ul>

          <h3>4.2 Paiements</h3>
          <p>
            Les paiements sont traités par Stripe. En souscrivant à un
            abonnement payant, vous acceptez les conditions de Stripe et
            autorisez le prélèvement automatique selon la fréquence choisie.
          </p>

          <h3>4.3 Résiliation</h3>
          <p>
            Vous pouvez annuler votre abonnement à tout moment depuis votre
            tableau de bord. L'annulation prendra effet à la fin de la période
            de facturation en cours. Aucun remboursement ne sera effectué pour
            la période déjà facturée.
          </p>

          <h2>5. Utilisation du service</h2>
          <h3>5.1 Utilisation acceptable</h3>
          <p>Vous vous engagez à :</p>
          <ul>
            <li>Utiliser le service de manière légale et éthique</li>
            <li>Ne pas usurper l'identité d'autrui</li>
            <li>
              Ne pas diffuser de contenu illégal, offensant ou inapproprié
            </li>
            <li>Ne pas tenter de compromettre la sécurité de la plateforme</li>
            <li>Respecter la vie privée des autres utilisateurs</li>
          </ul>

          <h3>5.2 Contenu utilisateur</h3>
          <p>
            Vous conservez tous les droits sur le contenu que vous publiez (nom
            de services, descriptions, etc.). En publiant du contenu, vous nous
            accordez une licence mondiale, non exclusive, pour utiliser, stocker
            et afficher ce contenu dans le cadre de la fourniture du service.
          </p>

          <h2>6. Réservations</h2>
          <h3>6.1 Responsabilités</h3>
          <p>Les professionnels sont responsables de :</p>
          <ul>
            <li>Maintenir leurs disponibilités à jour</li>
            <li>Honorer les réservations confirmées</li>
            <li>Informer les clients en cas d'annulation</li>
          </ul>

          <h3>6.2 Annulations</h3>
          <p>
            Les réservations peuvent être annulées par le professionnel ou le
            client. Les politiques d'annulation et de remboursement dépendent de
            chaque professionnel.
          </p>

          <h2>7. Propriété intellectuelle</h2>
          <p>
            Tous les droits de propriété intellectuelle sur la plateforme
            Synkron (code, design, logo, marque) appartiennent à Synkron. Vous
            ne pouvez pas copier, modifier, distribuer ou vendre tout ou partie
            de la plateforme sans notre autorisation écrite préalable.
          </p>

          <h2>8. Limitation de responsabilité</h2>
          <p>
            Synkron est fourni "tel quel" sans garantie d'aucune sorte. Nous ne
            garantissons pas que le service sera ininterrompu, sécurisé ou
            exempt d'erreurs.
          </p>
          <p>
            Dans la mesure permise par la loi, nous ne serons pas responsables
            des dommages indirects, accessoires, spéciaux ou consécutifs
            résultant de l'utilisation ou de l'impossibilité d'utiliser le
            service.
          </p>

          <h2>9. Modification du service</h2>
          <p>
            Nous nous réservons le droit de modifier, suspendre ou interrompre
            tout ou partie du service à tout moment, avec ou sans préavis. Nous
            ne serons pas responsables envers vous ou tout tiers pour toute
            modification, suspension ou interruption du service.
          </p>

          <h2>10. Résiliation</h2>
          <p>Nous pouvons suspendre ou résilier votre compte si :</p>
          <ul>
            <li>Vous violez ces CGU</li>
            <li>
              Votre utilisation met en danger le service ou d'autres
              utilisateurs
            </li>
            <li>Vous ne payez pas les frais d'abonnement</li>
            <li>Requis par la loi</li>
          </ul>

          <h2>11. Modifications des CGU</h2>
          <p>
            Nous pouvons modifier ces CGU à tout moment. Les modifications
            seront publiées sur cette page avec une nouvelle date de mise à
            jour. Votre utilisation continue du service après ces modifications
            constitue votre acceptation des nouvelles conditions.
          </p>

          <h2>12. Droit applicable</h2>
          <p>
            Ces CGU sont régies par le droit français. Tout litige sera soumis à
            la compétence exclusive des tribunaux français.
          </p>

          <h2>13. Contact</h2>
          <p>Pour toute question concernant ces CGU, contactez-nous à :</p>
          <ul>
            <li><strong>Email</strong> : legal@synkron.com</li>
            <li><strong>Adresse</strong> : [Votre adresse]</li>
          </ul>
        </div>

        <div class="mt-10 pt-8 border-t border-neutral-200 flex items-center justify-between">
          <BaseButton @click="$router.go(-1)" variant="secondary">
            <ArrowLeft class="w-4 h-4" />
            Retour
          </BaseButton>
          <router-link
            to="/privacy"
            class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
          >
            Voir la politique de confidentialité →
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
  @apply text-neutral-700 mb-4 leading-relaxed text-base;
}

.prose ul {
  @apply list-disc pl-6 mb-4 space-y-2;
}

.prose ul li {
  @apply text-neutral-700 text-base;
}

.prose strong {
  @apply font-semibold text-neutral-900;
}
</style>
