@php
  $headerColor = '#50c878';
  $headerTitle = 'Réservation confirmée';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; line-height: 20px;">
    Bonjour <strong>{{ $booking->client_name }}</strong>,
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Excellente nouvelle ! Votre réservation a été confirmée par le professionnel. Voici les détails de votre rendez-vous.
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #d4f9e2; border-left: 4px solid #50c878; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #1d5432; font-size: 13px; line-height: 18px;">
          <strong>Réservation confirmée</strong><br>
          Votre rendez-vous est maintenant validé. Merci de vous présenter à l'heure.
        </p>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; border: 1px solid #e6e6e6; border-radius: 12px; overflow: hidden;">
    <tr>
      <td style="padding: 16px; background-color: #f5f5f5; border-bottom: 1px solid #e6e6e6;">
        <p style="margin: 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">Détails de la réservation</p>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Service</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $service->name }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Date</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ \Carbon\Carbon::parse($booking->start_at)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Heure</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ \Carbon\Carbon::parse($booking->start_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_at)->format('H:i') }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Durée</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $service->duration_minutes }} min</td>
          </tr>
        </table>
      </td>
    </tr>
    @if($service->price)
    <tr>
      <td style="padding: 12px 16px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Prix</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ number_format($service->price, 2, ',', ' ') }} €</td>
          </tr>
        </table>
      </td>
    </tr>
    @endif
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #f5f5f5; border-radius: 12px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0 0 8px 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">Professionnel</p>
        <p style="margin: 0; color: #525252; font-size: 13px; line-height: 18px;">
          <strong style="color: #1a1f2e;">{{ $professional->business_name ?? $professional->name }}</strong><br>
          @if($professional->activity){{ $professional->activity }}<br>@endif
          {{ $professional->email }}
        </p>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0;">
    <tr>
      <td align="center">
        <a href="{{ config('app.frontend_url') }}/cancel/{{ $booking->cancellation_token }}" style="display: inline-block; padding: 10px 24px; background-color: transparent; color: #d45555; text-decoration: none; font-size: 14px; font-weight: 600; border: 2px solid #d45555; border-radius: 8px;">
          Annuler ma réservation
        </a>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; background-color: #fcf4db; border-left: 4px solid #d4a855; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #5a431f; font-size: 13px; line-height: 18px;">
          <strong>Rappel important</strong><br>
          Merci d'arriver à l'heure. Le lien d'annulation est à usage unique.
        </p>
      </td>
    </tr>
  </table>
@endsection
