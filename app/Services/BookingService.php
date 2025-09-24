<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Ticket;
use App\Data\BookingData;

class BookingService
{
    public function createBooking(Ticket $ticket, BookingData $data, $user): Booking
    {
        if ($data->quantity > $ticket->quantity) {
            abort(400, 'Not enough tickets available.');
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'ticket_id' => $ticket->id,
            'quantity' => $data->quantity,
            'status' => 'pending',
        ]);

        $ticket->decrement('quantity', $data->quantity);

        return $booking;
    }

    public function listUserBookings($user)
    {
        return Booking::with(['ticket.event'])
            ->where('user_id', $user->id)
            ->get();
    }

    public function cancelBooking(Booking $booking, $user): Booking
    {
        if ($booking->user_id !== $user->id) {
            abort(403, 'Forbidden');
        }

        $booking->update(['status' => 'cancelled']);
        return $booking;
    }

    public function listAllBookings()
    {
        return Booking::with(['user', 'ticket.event'])->get();
    }
}
