<?php

namespace App\Livewire\Ticket;

use App\Domains\Ticket\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination; // Para tener paginación reactiva sin recargar la página

    public function render()
    {
        // El Global Scope del Trait 'BelongsToCompany' se encarga de filtrar por ti entre bambalinas
        $tickets = Ticket::with(['user', 'assignee'])
            ->latest()
            ->paginate(10);

        return view('livewire.ticket.ticket-list', [
            'tickets' => $tickets
        ]);
    }
}