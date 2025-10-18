@php
  $headerColor = '#6b8dd6';
  $headerTitle = 'Nouvelle réservation';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; line-height: 20px;">
    Bonjour,
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Vous avez reçu une nouvelle demande de réservation de la part de <strong>{{ $booking->client_name }}</strong>.
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #d2e3fc; border-left: 4px solid #6b8dd6; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #1e2639; font-size: 13px; line-height: 18px;">
          <strong>Action requise</strong><br>
          Veuillez confirmer ou refuser cette réservation depuis votre tableau de bord.
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
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $booking->service->name }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Date et heure</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $booking->start_at->format('d/m/Y à H:i') }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px; border-bottom: 1px solid #e6e6e6;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Durée</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $booking->service->duration_minutes }} min</td>
          </tr>
        </table>
      </td>
    </tr>
    @if($booking->service->price)
    <tr>
      <td style="padding: 12px 16px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Tarif</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ number_format($booking->service->price, 2, ',', ' ') }} €</td>
          </tr>
        </table>
      </td>
    </tr>
    @endif
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #f5f5f5; border-radius: 12px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0 0 8px 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">Informations du client</p>
        <p style="margin: 0; color: #525252; font-size: 13px; line-height: 18px;">
          <strong style="color: #1a1f2e;">{{ $booking->client_name }}</strong><br>
          {{ $booking->client_email }}
        </p>
      </td>
    </tr>
  </table>

  @if($booking->notes)
  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #fcf4db; border-left: 4px solid #d4a855; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0 0 8px 0; color: #5a431f; font-size: 13px; font-weight: 600;">Note du client</p>
        <p style="margin: 0; color: #5a431f; font-size: 13px; line-height: 18px;">
          {{ $booking->notes }}
        </p>
      </td>
    </tr>
  </table>
  @endif

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0;">
    <tr>
      <td align="center">
        <a href="{{ $dashboardUrl }}" style="display: inline-block; padding: 10px 24px; background-color: #6b8dd6; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 8px;">
          Voir mes réservations
        </a>
      </td>
    </tr>
  </table>
@endsection
