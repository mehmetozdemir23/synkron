<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
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
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isPro(): bool
    {
        return $this->subscribed(self::PLAN_PRO);
    }

    public function getMonthlyBookingCount(): int
    {
        return $this->bookings()
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
    }

    public function canCreateBooking(): bool
    {
        if ($this->isPro()) {
            return true;
        }

        return $this->getMonthlyBookingCount() < self::FREE_BOOKING_LIMIT;
    }

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

    public static function generateSlug(string $name, ?int $excludeUserId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = self::where('slug', $slug);

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;

            $query = self::where('slug', $slug);
            if ($excludeUserId) {
                $query->where('id', '!=', $excludeUserId);
            }
        }

        return $slug;
    }
}
