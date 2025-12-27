<template>
  <div class="min-h-screen bg-neutral-50 flex flex-col">
    <PublicHeader />

    <div class="flex-1 max-w-4xl mx-auto w-full px-4 py-12 sm:py-16">
      <div class="bg-neutral-100 rounded-xl shadow-md p-8 sm:p-10 md:p-12">
        <div class="mb-8 pb-8 border-b border-neutral-300">
          <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-3">
            Conditions Générales d'Utilisation
          </h1>
          <p class="text-sm text-neutral-500">
            Dernière mise à jour : {{ lastUpdate }}
          </p>
        </div>

        <div class="space-y-8">
          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              1. Acceptation des conditions
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              En accédant et en utilisant Synkron ("<strong
                class="font-semibold text-neutral-900"
                >la plateforme</strong
              >", "<strong class="font-semibold text-neutral-900"
                >le service</strong
              >"), vous acceptez d'être lié par ces Conditions Générales
              d'Utilisation ("<strong class="font-semibold text-neutral-900"
                >CGU</strong
              >"). Si vous n'acceptez pas ces conditions, veuillez ne pas
              utiliser la plateforme.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              2. Description du service
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Synkron est une plateforme SaaS permettant aux professionnels de
              gérer leurs disponibilités, leurs services et de recevoir des
              réservations en ligne de la part de leurs clients.
            </p>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Le service comprend :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                Gestion de profil professionnel
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Création et gestion de services
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Configuration des disponibilités
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Système de réservation en ligne
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Notifications par email
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Gestion des abonnements (gratuit et premium)
              </li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              3. Inscription et compte
            </h2>
            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              3.1 Conditions d'inscription
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Pour utiliser la plateforme, vous devez :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">Avoir au moins 18 ans</li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Fournir des informations exactes et complètes
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Maintenir vos informations à jour
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Être responsable de la confidentialité de votre mot de passe
              </li>
            </ul>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              3.2 Responsabilité du compte
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Vous êtes responsable de toutes les activités effectuées sous
              votre compte. Vous devez nous informer immédiatement de toute
              utilisation non autorisée de votre compte.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              4. Abonnements et paiements
            </h2>
            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              4.1 Plans disponibles
            </h3>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900"
                  >Plan Gratuit</strong
                >
                : Limité à 10 réservations par mois
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                <strong class="font-semibold text-neutral-900">Plan Pro</strong>
                : Réservations illimitées, moyennant un abonnement mensuel ou
                annuel
              </li>
            </ul>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              4.2 Paiements
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Les paiements sont traités par Stripe. En souscrivant à un
              abonnement payant, vous acceptez les conditions de Stripe et
              autorisez le prélèvement automatique selon la fréquence choisie.
            </p>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              4.3 Résiliation
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Vous pouvez annuler votre abonnement à tout moment depuis votre
              tableau de bord. L'annulation prendra effet à la fin de la période
              de facturation en cours. Aucun remboursement ne sera effectué pour
              la période déjà facturée.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              5. Utilisation du service
            </h2>
            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              5.1 Utilisation acceptable
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Vous vous engagez à :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                Utiliser le service de manière légale et éthique
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Ne pas usurper l'identité d'autrui
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Ne pas diffuser de contenu illégal, offensant ou inapproprié
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Ne pas tenter de compromettre la sécurité de la plateforme
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Respecter la vie privée des autres utilisateurs
              </li>
            </ul>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              5.2 Contenu utilisateur
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Vous conservez tous les droits sur le contenu que vous publiez
              (nom de services, descriptions, etc.). En publiant du contenu,
              vous nous accordez une licence mondiale, non exclusive, pour
              utiliser, stocker et afficher ce contenu dans le cadre de la
              fourniture du service.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              6. Réservations
            </h2>
            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              6.1 Responsabilités
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Les professionnels sont responsables de :
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">
                Maintenir leurs disponibilités à jour
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Honorer les réservations confirmées
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Informer les clients en cas d'annulation
              </li>
            </ul>

            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 mt-6 mb-3">
              6.2 Annulations
            </h3>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Les réservations peuvent être annulées par le professionnel ou le
              client. Les politiques d'annulation et de remboursement dépendent
              de chaque professionnel.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              7. Propriété intellectuelle
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Tous les droits de propriété intellectuelle sur la plateforme
              Synkron (code, design, logo, marque) appartiennent à Synkron. Vous
              ne pouvez pas copier, modifier, distribuer ou vendre tout ou
              partie de la plateforme sans notre autorisation écrite préalable.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              8. Limitation de responsabilité
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Synkron est fourni "tel quel" sans garantie d'aucune sorte. Nous
              ne garantissons pas que le service sera ininterrompu, sécurisé ou
              exempt d'erreurs.
            </p>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Dans la mesure permise par la loi, nous ne serons pas responsables
              des dommages indirects, accessoires, spéciaux ou consécutifs
              résultant de l'utilisation ou de l'impossibilité d'utiliser le
              service.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              9. Modification du service
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous nous réservons le droit de modifier, suspendre ou interrompre
              tout ou partie du service à tout moment, avec ou sans préavis.
              Nous ne serons pas responsables envers vous ou tout tiers pour
              toute modification, suspension ou interruption du service.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              10. Résiliation
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Nous pouvons suspendre ou résilier votre compte si :
            </p>
            <ul class="list-disc pl-6 space-y-2">
              <li class="text-neutral-600 text-sm sm:text-base">Vous violez ces CGU</li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Votre utilisation met en danger le service ou d'autres
                utilisateurs
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">
                Vous ne payez pas les frais d'abonnement
              </li>
              <li class="text-neutral-600 text-sm sm:text-base">Requis par la loi</li>
            </ul>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              11. Modifications des CGU
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Nous pouvons modifier ces CGU à tout moment. Les modifications
              seront publiées sur cette page avec une nouvelle date de mise à
              jour. Votre utilisation continue du service après ces
              modifications constitue votre acceptation des nouvelles
              conditions.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              12. Droit applicable
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base">
              Ces CGU sont régies par le droit français. Tout litige sera soumis
              à la compétence exclusive des tribunaux français.
            </p>
          </section>

          <section>
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-4">
              13. Contact
            </h2>
            <p class="text-neutral-600 leading-relaxed text-sm sm:text-base mb-4">
              Pour toute question concernant ces CGU, contactez-nous à :
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
