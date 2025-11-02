# Synkron

Plateforme SaaS de gestion des réservations pour professionnels. Simplifiez vos réservations avec un lien unique pour toutes vos prises de rendez-vous.

## Fonctionnalités

- **10 réservations/mois gratuites** - Commencez sans risque, sans carte bancaire
- **Services illimités** - Créez autant de services que nécessaire
- **Notifications par email** - Alerté à chaque nouvelle réservation
- **Page de réservation** - Votre lien unique à partager

## Installation

### Backend
```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend
```bash
cd web
npm install
npm run dev
```

## Tests

```bash
cd api
./vendor/bin/phpunit
```
