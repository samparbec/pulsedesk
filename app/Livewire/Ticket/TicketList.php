<?php

namespace App\Livewire\Ticket;

use App\Domains\Ticket\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class TicketList extends Component
{
    use WithPagination; // Para tener paginación reactiva sin recargar la página

    // Le decimos a Livewire que si escucha el evento 'ticket-created', refresque este componente
    #[On('ticket-created')]
    public function refreshList()
    {
        // Al dejarlo vacío, Livewire simplemente vuelve a ejecutar el método render() automáticamente
    }

    public function render()
    {
        // 📊 CALCULADORA DE WIDGETS (Aislados por Tenant automáticamente gracias al Scope)
        // Hacemos las queries rápidas contando por estado
        $metrics = [
            'open'        => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved'    => Ticket::where('status', 'resolved')->count(),
            'total'       => Ticket::count(),
        ];
        // El Global Scope del Trait 'BelongsToCompany' se encarga de filtrar por ti entre bambalinas
        $tickets = Ticket::with(['user', 'assignee'])
            ->latest()
            ->paginate(10);

        return view('livewire.ticket.ticket-list', [
            'tickets' => $tickets,
            'metrics' => $metrics
        ]);
    }
}