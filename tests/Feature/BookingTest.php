<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;

it('customer can book a ticket', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $token = $customer->createToken('test')->plainTextToken;

    $event = Event::factory()->create();
    $ticket = Ticket::factory()->create(['event_id' => $event->id, 'quantity' => 10]);

    $response = $this->postJson("/api/tickets/{$ticket->id}/bookings", [
        'quantity' => 2
    ], [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment(['status' => 'pending']);
});
