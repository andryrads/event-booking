<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $service) {}

    /**
     * Process a payment for the specified booking (Customer only).
     * 
     * @param int $id Booking ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $booking = Booking::with('ticket')->findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Forbidden');
        }

        $payment = $this->service->processPayment($booking);
        return response()->json($payment, 201);
    }

    /**
     * Retrieve details of a specific payment.
     * Accessible by Admin (any payment) or the Customer who owns the booking.
     * 
     * @param int $id Payment ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payment = $this->service->getPayment($id);

        if (auth()->user()->role !== 'admin' && $payment->booking->user_id !== auth()->id()) {
            abort(403, 'Forbidden');
        }

        return response()->json($payment);
    }
}
