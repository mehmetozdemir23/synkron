<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demo = User::create([
            'firstname' => 'Marie',
            'lastname' => 'Dupont',
            'email' => 'demo@synkron.app',
            'password' => Hash::make('demo1234'),
            'slug' => 'marie-dupont',
            'business_name' => 'Cabinet Marie Dupont',
            'activity' => 'Psychologue clinicienne',
            'timezone' => 'Europe/Paris',
        ]);

        $services = [
            [
                'name' => 'Consultation individuelle',
                'description' => 'Séance de thérapie individuelle pour adultes. Approche cognitivo-comportementale.',
                'duration_minutes' => 60,
                'price' => 70.00,
                'is_active' => true,
            ],
            [
                'name' => 'Consultation de couple',
                'description' => 'Thérapie de couple pour améliorer la communication et résoudre les conflits.',
                'duration_minutes' => 90,
                'price' => 100.00,
                'is_active' => true,
            ],
            [
                'name' => 'Séance de groupe',
                'description' => 'Groupe de parole sur la gestion du stress et de l\'anxiété (6 personnes max).',
                'duration_minutes' => 120,
                'price' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Consultation enfant/ado',
                'description' => 'Accompagnement psychologique pour enfants et adolescents.',
                'duration_minutes' => 45,
                'price' => 60.00,
                'is_active' => false,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create(array_merge($serviceData, ['user_id' => $demo->id]));
        }

        $workDays = [1, 2, 3, 4, 5];
        foreach ($workDays as $day) {
            Availability::create([
                'user_id' => $demo->id,
                'day_of_week' => $day,
                'start_time' => '09:00',
                'end_time' => '12:00',
            ]);
            Availability::create([
                'user_id' => $demo->id,
                'day_of_week' => $day,
                'start_time' => '14:00',
                'end_time' => '18:00',
            ]);
        }

        $firstService = $demo->services()->first();
        $tomorrow = Carbon::tomorrow()->setTime(10, 0);
        $nextWeek = Carbon::now()->addWeek()->setTime(15, 0);
        $lastWeek = Carbon::now()->subWeek()->setTime(11, 0);

        Booking::create([
            'user_id' => $demo->id,
            'service_id' => $firstService->id,
            'client_name' => 'Sophie Martin',
            'client_email' => 'sophie.martin@example.com',
            'notes' => 'Première consultation - Gestion du stress',
            'start_at' => $tomorrow,
            'end_at' => $tomorrow->copy()->addMinutes(60),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        Booking::create([
            'user_id' => $demo->id,
            'service_id' => $firstService->id,
            'client_name' => 'Thomas Bernard',
            'client_email' => 'thomas.bernard@example.com',
            'notes' => 'Suivi mensuel',
            'start_at' => $nextWeek,
            'end_at' => $nextWeek->copy()->addMinutes(60),
            'status' => BookingStatus::PENDING->value,
        ]);

        Booking::create([
            'user_id' => $demo->id,
            'service_id' => $firstService->id,
            'client_name' => 'Claire Dubois',
            'client_email' => 'claire.dubois@example.com',
            'start_at' => $lastWeek,
            'end_at' => $lastWeek->copy()->addMinutes(60),
            'status' => BookingStatus::CONFIRMED->value,
        ]);
    }
}
