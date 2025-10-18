@php
  $headerColor = '#d4a855';
  $headerTitle = 'Annulation de réservation';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; line-height: 20px;">
    Bonjour,
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Une réservation a été annulée par le client. Voici les détails :
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #fcf4db; border-left: 4px solid #d4a855; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #5a431f; font-size: 13px; line-height: 18px;">
          <strong>Créneau libéré</strong><br>
          Ce créneau horaire est maintenant disponible pour d'autres réservations. Vous pouvez le consulter dans votre calendrier.
        </p>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; border: 1px solid #e6e6e6; border-radius: 12px; overflow: hidden;">
    <tr>
      <td style="padding: 16px; background-color: #f5f5f5; border-bottom: 1px solid #e6e6e6;">
        <p style="margin: 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">Détails de la réservation annulée</p>
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
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ $service->duration_minutes }} minutes</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Date d'annulation</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ \Carbon\Carbon::parse($booking->cancelled_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</td>
          </tr>
        </table>
      </td>
    </tr>
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

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0;">
    <tr>
      <td align="center">
        <a href="{{ config('app.frontend_url') }}/dashboard/bookings" style="display: inline-block; padding: 10px 24px; background-color: #6b8dd6; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 8px;">
          Consulter mon calendrier
        </a>
      </td>
    </tr>
  </table>
@endsection
