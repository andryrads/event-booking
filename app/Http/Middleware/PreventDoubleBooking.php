<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Booking;

class PreventDoubleBooking
{
     /**
     * Handle an incoming request.
     *
     * Prevent a user from booking the same ticket more than once,
     * unless the previous booking was cancelled.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $ticketId = $request->route('id');
        $userId   = $request->user()->id;

        $alreadyBooked = Booking::where('ticket_id', $ticketId)
            ->where('user_id', $userId)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'message' => 'You have already booked this ticket.'
            ], 400);
        }

        return $next($request);
    }
}
