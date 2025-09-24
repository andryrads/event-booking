<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;

class PaymentService
{
    public function processPayment(Booking $booking): Payment
    {
        $status = rand(0, 1) ? 'success' : 'failed';

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->quantity * $booking->ticket->price,
            'status' => $status,
        ]);

        if ($status === 'success') {
            $booking->update(['status' => 'confirmed']);
        }

        return $payment;
    }

    public function getPayment($id): Payment
    {
        return Payment::with('booking.user', 'booking.ticket.event')->findOrFail($id);
    }
}
