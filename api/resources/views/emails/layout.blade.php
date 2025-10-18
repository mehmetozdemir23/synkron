<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5;">
    <tr>
      <td align="center" style="padding: 40px 16px;">
        
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

          
          <tr>
            <td align="center" style="padding: 24px 24px 16px 24px; background-color: #ffffff;">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -2 168 32" width="140" height="28">
                
                <rect x="0" y="0" width="28" height="28" rx="4" ry="4" fill="#4f6fa8"/>

                
                <g transform="translate(14, 14)">
                  <g transform="scale(0.4)">
                    <g transform="translate(-26, -30)">
                      <path d="M 44 8 Q 14 8 14 22 L 14 26" fill="none" stroke="#fff" stroke-width="6.5" stroke-linecap="round"/>
                      <path d="M 7 27 L 14 34 L 21 27" fill="none" stroke="#fff" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M 8 52 Q 38 52 38 38 L 38 34" fill="none" stroke="#fff" stroke-width="6.5" stroke-linecap="round"/>
                      <path d="M 45 33 L 38 26 L 31 33" fill="none" stroke="#fff" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                  </g>
                </g>

                
                <text x="35" y="24" font-family="'Inter', -apple-system, sans-serif" font-weight="600" font-size="28" letter-spacing="-0.02em" fill="#1a1f2e">Synkron</text>
              </svg>
            </td>
          </tr>

          
          <tr>
            <td style="background-color: {{ $headerColor }}; padding: 32px 24px; text-align: center;">
              <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600; letter-spacing: 0;">
                {{ $headerTitle }}
              </h1>
            </td>
          </tr>

          
          <tr>
            <td style="padding: 32px 24px;">
              @yield('content')
            </td>
          </tr>

          
          <tr>
            <td style="padding: 24px; background-color: #f5f5f5; border-top: 1px solid #e6e6e6; text-align: center;">
              <p style="margin: 0 0 8px 0; color: #525252; font-size: 12px; line-height: 16px;">
                Cet email a été envoyé par <strong style="color: #1a1f2e;">Synkron</strong>
              </p>
              <p style="margin: 0; color: #b3b3b3; font-size: 11px; line-height: 16px;">
                © 2025 Synkron. Tous droits réservés.
              </p>
              <p style="margin: 12px 0 0 0;">
                <a href="mailto:support@synkron.app" style="color: #4f6fa8; text-decoration: none; font-size: 12px;">Contactez-nous</a>
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
