<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;

it('customer can pay for a booking', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $token = $customer->createToken('test')->plainTextToken;

    $event = Event::factory()->create();
    $ticket = Ticket::factory()->create(['event_id' => $event->id, 'quantity' => 10]);
    $booking = Booking::factory()->create([
        'user_id' => $customer->id,
        'ticket_id' => $ticket->id,
        'quantity' => 1,
        'status' => 'pending'
    ]);

    $response = $this->postJson("/api/bookings/{$booking->id}/payment", [], [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['id', 'status', 'amount']);
});
