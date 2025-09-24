<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Data\EventData;

class EventService
{
    public function listEvents(array $filters)
    {
        $cacheKey = 'events_list_' . md5(json_encode($filters));

        return Cache::remember($cacheKey, 60, function () use ($filters) {
            $query = Event::with('tickets');

            if (!empty($filters['search'])) {
                $query->searchByTitle($filters['search']);
            }

            if (!empty($filters['date'])) {
                $query->filterByDate($filters['date']);
            }

            if (!empty($filters['location'])) {
                $query->where('location', 'LIKE', '%' . $filters['location'] . '%');
            }

            return $query->paginate(10);
        });
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
