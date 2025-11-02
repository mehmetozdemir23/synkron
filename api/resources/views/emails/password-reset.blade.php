@php
  $headerColor = '#6b8dd6';
  $headerTitle = 'Réinitialisation de mot de passe';
@endphp

@extends('emails.layout')

@section('content')
  
  <p style="margin: 0 0 16px 0; color: #1a1f2e; font-size: 14px; line-height: 20px;">
    Bonjour,
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Vous avez demandé à réinitialiser le mot de passe de votre compte Synkron associé à l'adresse email <strong style="color: #1a1f2e;">{{ $email }}</strong>.
  </p>

  <p style="margin: 0 0 24px 0; color: #525252; font-size: 14px; line-height: 20px;">
    Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :
  </p>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0;">
    <tr>
      <td align="center">
        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 12px 32px; background-color: #6b8dd6; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 8px;">
          Réinitialiser mon mot de passe
        </a>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #fcf4db; border-left: 4px solid #d4a855; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #5a431f; font-size: 13px; line-height: 18px;">
          <strong>Lien de sécurité</strong><br>
          Ce lien est valide pendant <strong>60 minutes</strong> et ne peut être utilisé qu'une seule fois.
        </p>
      </td>
    </tr>
  </table>

  
  <p style="margin: 0 0 12px 0; color: #1a1f2e; font-size: 13px; font-weight: 600;">
    Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :
  </p>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px 0; background-color: #f5f5f5; border: 1px solid #e6e6e6; border-radius: 8px;">
    <tr>
      <td style="padding: 16px; word-break: break-all;">
        <p style="margin: 0; color: #4f6fa8; font-size: 12px; font-family: monospace;">{{ $resetUrl }}</p>
      </td>
    </tr>
  </table>

  
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; background-color: #d2e3fc; border-left: 4px solid #6b8dd6; border-radius: 8px;">
    <tr>
      <td style="padding: 16px;">
        <p style="margin: 0; color: #1e2639; font-size: 13px; line-height: 18px;">
          <strong>Vous n'avez pas demandé cette réinitialisation ?</strong><br>
          Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet email. Votre mot de passe actuel restera inchangé.
        </p>
      </td>
    </tr>
  </table>
@endsection
