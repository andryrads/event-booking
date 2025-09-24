<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use App\Data\TicketData;

class TicketService
{
    public function createTicket(Event $event, TicketData $data, $user): Ticket
    {
        if ($user->role === 'organizer' && $event->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }

        return $event->tickets()->create($data->toArray());
    }

    public function updateTicket(Ticket $ticket, TicketData $data, $user): Ticket
    {
        if ($user->role === 'organizer' && $ticket->event->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }

        $ticket->update($data->toArray());
        return $ticket;
    }

    public function deleteTicket(Ticket $ticket, $user): void
    {
        if ($user->role === 'organizer' && $ticket->event->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }

        $ticket->delete();
    }
}
