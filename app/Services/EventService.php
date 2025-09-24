<?php

namespace App\Services;

use App\Models\Event;
use App\Data\EventData;

class EventService
{
    public function listEvents(array $filters)
    {
        return Event::with('tickets')
            ->filterByDate($filters['date'] ?? null)
            ->searchByTitle($filters['search'] ?? null)
            ->when(isset($filters['location']), fn ($q) =>
                $q->where('location', 'ILIKE', "%{$filters['location']}%")
            )
            ->paginate(10);
    }

    public function createEvent(EventData $data, int $userId): Event
    {
        return Event::create([
            ...$data->toArray(),
            'created_by' => $userId,
        ]);
    }

    public function updateEvent(Event $event, EventData $data, $user): Event
    {
        if ($user->role === 'organizer' && $event->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }
        $event->update($data->toArray());
        return $event;
    }

    public function deleteEvent(Event $event, $user): void
    {
        if ($user->role === 'organizer' && $event->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }
        $event->delete();
    }
}
