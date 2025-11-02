@php
  $headerColor = '#d45555';
  $headerTitle = 'Demande refusée';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; line-height: 20px;">
    Bonjour <strong>{{ $booking->client_name }}</strong>,
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Nous sommes désolés de vous informer que votre demande de réservation a été refusée par le professionnel.
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #fcdbdb; border-left: 4px solid #d45555; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #5a1f1f; font-size: 13px; line-height: 18px;">
          <strong>Demande refusée</strong><br>
          Le professionnel n'a pas pu accepter cette demande. Vous pouvez le contacter pour plus d'informations.
        </p>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; border: 1px solid #e6e6e6; border-radius: 12px; overflow: hidden;">
    <tr>
      <td style="padding: 16px; background-color: #f5f5f5; border-bottom: 1px solid #e6e6e6;">
        <p style="margin: 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">Détails de la demande</p>
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
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Date demandée</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ \Carbon\Carbon::parse($booking->start_at)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 12px 16px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td style="color: #525252; font-size: 13px; line-height: 18px;">Heure demandée</td>
            <td align="right" style="color: #1a1f2e; font-size: 13px; font-weight: 600; line-height: 18px;">{{ \Carbon\Carbon::parse($booking->start_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_at)->format('H:i') }}</td>
          </tr>
        </table>
      </td>
    </tr>
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

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; background-color: #d2e3fc; border-left: 4px solid #6b8dd6; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #1e2639; font-size: 13px; line-height: 18px;">
          <strong>Que faire maintenant ?</strong><br>
          Vous pouvez contacter directement le professionnel pour discuter de la raison du refus ou proposer une autre date.
        </p>
      </td>
    </tr>
  </table>
@endsection
