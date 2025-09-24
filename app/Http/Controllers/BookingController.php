<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Data\BookingData;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $service) {}

    /**
     * Create a new booking for the given ticket (Customer only).
     *
     * @param \App\Http\Requests\StoreBookingRequest $request
     * @param int $ticketId Ticket ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookingRequest $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $data = BookingData::from($request->validated());
        $booking = $this->service->createBooking($ticket, $data, $request->user());
        return response()->json($booking, 201);
    }

    /**
     * Retrieve all bookings belonging to the authenticated customer.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            $this->service->listUserBookings($request->user())
        );
    }

    /**
     * Cancel a booking owned by the authenticated customer.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Booking ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $cancelled = $this->service->cancelBooking($booking, $request->user());
        return response()->json($cancelled);
    }

    /**
     * Retrieve all bookings in the system (Admin only).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json(
            $this->service->listAllBookings()
        );
    }
}
