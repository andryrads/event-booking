<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Services\PaymentService;

it('processes a payment', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $event = Event::factory()->create();
    $ticket = Ticket::factory()->create([
        'event_id' => $event->id,
        'price' => 1000,
        'quantity' => 10,
    ]);

    $booking = Booking::factory()->create([
        'user_id' => $customer->id,
        'ticket_id' => $ticket->id,
        'quantity' => 2,
        'status' => 'pending',
    ]);

    $service = new PaymentService();
    $payment = $service->processPayment($booking);

    $expectedAmount = $booking->quantity * $ticket->price;

    expect($payment->amount)->toEqual($expectedAmount)
        ->and(in_array($payment->status, ['success', 'failed']))->toBeTrue();
});
