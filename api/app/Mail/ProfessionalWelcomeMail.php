<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfessionalWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $businessName,
        public string $dashboardUrl
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenue sur Synkron!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.professional-welcome',
            with: [
                'name' => $this->name,
                'businessName' => $this->businessName,
                'dashboardUrl' => $this->dashboardUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
