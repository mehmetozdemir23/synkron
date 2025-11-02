<?php

namespace App\Notifications;

use App\Mail\ProfessionalWelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ProfessionalWelcome extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $name,
        public string $businessName
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): ProfessionalWelcomeMail
    {
        $dashboardUrl = config('app.frontend_url').'/dashboard';

        return new ProfessionalWelcomeMail(
            name: $this->name,
            businessName: $this->businessName,
            dashboardUrl: $dashboardUrl
        )->to($notifiable->email);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'business_name' => $this->businessName,
        ];
    }
}
