<?php

namespace App\Notifications;

use App\Mail\NewBookingMail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): NewBookingMail
    {
        $dashboardUrl = config('app.frontend_url').'/dashboard/bookings';

        return new NewBookingMail(
            booking: $this->booking,
            dashboardUrl: $dashboardUrl
        )->to($notifiable->email);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'client_name' => $this->booking->client_name,
            'service_name' => $this->booking->service->name,
        ];
    }
}
