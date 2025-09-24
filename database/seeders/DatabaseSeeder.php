<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::factory()->count(2)->create(['role' => 'admin']);
        User::factory()->count(3)->create(['role' => 'organizer']);
        User::factory()->count(10)->create(['role' => 'customer']);

        // Fixed users for testing login
        User::create([
            'name' => 'Admin One',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Organizer One',
            'email' => 'organizer@example.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        User::create([
            'name' => 'Customer One',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Events + Tickets
        Event::factory()
            ->count(5)
            ->has(Ticket::factory()->count(3))
            ->create();

        // Bookings + Payments
        Booking::factory()
            ->count(20)
            ->has(Payment::factory())
            ->create();
    }
}
