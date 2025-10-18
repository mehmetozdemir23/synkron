<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $dashboardUrl
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle réservation reçue!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-booking',
            with: [
                'booking' => $this->booking,
                'dashboardUrl' => $this->dashboardUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
