<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Services\TicketService;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Data\TicketData;

class TicketController extends Controller
{
    public function __construct(private TicketService $service) {}

    /**
     * Create a new ticket for the specified event (Organizer/Admin only).
     * 
     * @param \App\Http\Requests\StoreTicketRequest $request
     * @param int $eventId Event ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketRequest $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $data = TicketData::from($request->validated());
        $ticket = $this->service->createTicket($event, $data, $request->user());
        return response()->json($ticket, 201);
    }

    /**
     * Update the specified ticket (Organizer for own event, Admin for all).
     * 
     * @param \App\Http\Requests\UpdateTicketRequest $request
     * @param int $id Ticket ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = Ticket::with('event')->findOrFail($id);
        $data = TicketData::from($request->validated());
        $updated = $this->service->updateTicket($ticket, $data, $request->user());
        return response()->json($updated);
    }

    /**
     * Delete the specified ticket (Organizer for own event, Admin for all).
     * 
     * @param int $id Ticket ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ticket = Ticket::with('event')->findOrFail($id);
        $this->service->deleteTicket($ticket, request()->user());
        return response()->json(['message' => 'Ticket deleted']);
    }
}

