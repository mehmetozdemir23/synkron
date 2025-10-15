<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Billable, HasApiTokens, HasFactory, Notifiable;

    const PLAN_FREE = 'free';

    const PLAN_PRO = 'pro';

    const FREE_BOOKING_LIMIT = 10;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'slug',
        'business_name',
        'activity',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's services.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the user's availabilities.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the bookings received by the professional.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if user has an active Pro subscription.
     */
    public function isPro(): bool
    {
        return $this->subscribed(self::PLAN_PRO);
    }

    /**
     * Get the number of bookings created this month.
     */
    public function getMonthlyBookingCount(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        return $this->bookings()
            ->where('created_at', '>=', $startOfMonth)
            ->count();
    }

    /**
     * Check if user can create a new booking.
     */
    public function canCreateBooking(): bool
    {
        if ($this->services()->active()->count() === 0) {
            return false;
        }

        if ($this->isPro()) {
            return true;
        }

        return $this->getMonthlyBookingCount() < self::FREE_BOOKING_LIMIT;
    }

    /**
     * Get usage data for the user.
     */
    public function getUsageData(): array
    {
        $isPro = $this->isPro();
        $used = $this->getMonthlyBookingCount();
        $limit = self::FREE_BOOKING_LIMIT;

        return [
            'plan' => $isPro ? 'pro' : 'free',
            'is_pro' => $isPro,
            'used' => $used,
            'limit' => $isPro ? null : $limit,
            'can_book' => $this->canCreateBooking(),
            'percentage' => $isPro ? 0 : min(100, round(($used / $limit) * 100)),
        ];
    }
}
