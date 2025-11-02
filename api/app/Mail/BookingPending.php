<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingPending extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Demande de réservation reçue - '.$this->booking->service->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-pending',
            with: [
                'booking' => $this->booking,
                'service' => $this->booking->service,
                'professional' => $this->booking->professional,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
