<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aperçu des emails - Synkron</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f5f5f5;
      padding: 40px 20px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
    }
    h1 {
      color: #202124;
      font-size: 32px;
      font-weight: 400;
      margin-bottom: 8px;
    }
    .subtitle {
      color: #5f6368;
      font-size: 14px;
      margin-bottom: 32px;
    }
    .email-list {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 1px 3px 0 rgba(60, 64, 67, 0.3), 0 4px 8px 3px rgba(60, 64, 67, 0.15);
      overflow: hidden;
    }
    .email-item {
      display: block;
      padding: 16px 24px;
      border-bottom: 1px solid #e8eaed;
      text-decoration: none;
      color: #202124;
      transition: background-color 0.2s;
    }
    .email-item:last-child {
      border-bottom: none;
    }
    .email-item:hover {
      background-color: #f8f9fa;
    }
    .email-name {
      font-size: 14px;
      font-weight: 500;
      color: #1a73e8;
      margin-bottom: 4px;
    }
    .email-description {
      font-size: 13px;
      color: #5f6368;
    }
    .badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 500;
      margin-left: 8px;
    }
    .badge-client {
      background-color: #e8f0fe;
      color: #1a73e8;
    }
    .badge-pro {
      background-color: #fef7e0;
      color: #f59e0b;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Aperçu des emails</h1>
    <p class="subtitle">Prévisualisation des templates d'email Synkron</p>

    <div class="email-list">
      @foreach($emails as $slug => $name)
        <a href="/email-preview/{{ $slug }}" class="email-item">
          <div class="email-name">
            {{ $name }}
            @if(str_contains($name, 'client'))
              <span class="badge badge-client">Client</span>
            @else
              <span class="badge badge-pro">Pro</span>
            @endif
          </div>
          <div class="email-description">/email-preview/{{ $slug }}</div>
        </a>
      @endforeach
    </div>
  </div>
</body>
</html>
