@php
  $headerColor = '#6b8dd6';
  $headerTitle = 'Bienvenue sur Synkron';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 16px; line-height: 24px; font-weight: 600;">
    Bienvenue {{ $name }} !
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Merci d'avoir rejoint <strong>Synkron</strong>. Vous êtes maintenant prêt à gérer vos réservations facilement et efficacement.
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #d2e3fc; border-left: 4px solid #6b8dd6; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #1e2639; font-size: 13px; line-height: 18px;">
          <strong>Plan Gratuit activé</strong><br>
          Vous avez droit à <strong>10 réservations gratuites par mois</strong>. Aucune carte bancaire requise. Passez à la formule Pro pour bénéficier de réservations illimitées et de fonctionnalités avancées.
        </p>
      </td>
    </tr>
  </table>

  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; font-weight: 600;">
    Prochaines étapes recommandées :
  </p>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #f5f5f5; border-radius: 12px; padding: 16px;">
    <tr>
      <td style="padding: 8px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width: 32px; vertical-align: top;">
              <span style="display: inline-block; width: 24px; height: 24px; background-color: #6b8dd6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 600;">1</span>
            </td>
            <td style="color: #525252; font-size: 14px; line-height: 20px; padding-left: 8px;">
              Créer vos services et définir vos tarifs
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 8px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width: 32px; vertical-align: top;">
              <span style="display: inline-block; width: 24px; height: 24px; background-color: #6b8dd6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 600;">2</span>
            </td>
            <td style="color: #525252; font-size: 14px; line-height: 20px; padding-left: 8px;">
              Configurer vos créneaux disponibles
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 8px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width: 32px; vertical-align: top;">
              <span style="display: inline-block; width: 24px; height: 24px; background-color: #6b8dd6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 600;">3</span>
            </td>
            <td style="color: #525252; font-size: 14px; line-height: 20px; padding-left: 8px;">
              Partager votre page de réservation unique
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 8px 0;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width: 32px; vertical-align: top;">
              <span style="display: inline-block; width: 24px; height: 24px; background-color: #6b8dd6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 600;">4</span>
            </td>
            <td style="color: #525252; font-size: 14px; line-height: 20px; padding-left: 8px;">
              Recevoir des notifications pour chaque réservation
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0;">
    <tr>
      <td align="center">
        <a href="{{ $dashboardUrl }}" style="display: inline-block; padding: 12px 32px; background-color: #6b8dd6; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 8px;">
          Accéder à mon tableau de bord
        </a>
      </td>
    </tr>
  </table>
@endsection
