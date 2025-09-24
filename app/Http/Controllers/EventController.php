<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Data\EventData;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(private EventService $service) {}

    /**
     * Display a list of events with optional filters (search, date, location).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            $this->service->listEvents($request->all())
        );
    }

    /**
     * Display the specified event along with its tickets.
     *
     * @param int $id Event ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Event::with('tickets')->findOrFail($id));
    }

    /**
     * Create a new event (Organizer/Admin only).
     *
     * @param \App\Http\Requests\StoreEventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEventRequest $request)
    {
        $data = EventData::from($request->validated());
        $event = $this->service->createEvent($data, $request->user()->id);
        return response()->json($event, 201);
    }

    /**
     * Update the specified event (Organizer for own events, Admin for all).
     *
     * @param \App\Http\Requests\UpdateEventRequest $request
     * @param int $id Event ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $data = EventData::from($request->validated());
        $updated = $this->service->updateEvent($event, $data, $request->user());
        return response()->json($updated);
    }

    /**
     * Delete the specified event (Organizer for own events, Admin for all).
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Event ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $this->service->deleteEvent($event, $request->user());
        return response()->json(['message' => 'Event deleted']);
    }
}


