<?php

namespace App\Livewire\Ticket;

use App\Domains\Ticket\Actions\CreateTicketAction;
use App\Domains\Ticket\DTOs\CreateTicketData;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTicket extends Component
{
    public bool $isOpen = false;
    // Propiedades vinculadas al formulario (wire:model)
    public string $subject = '';
    public string $description = '';
    public string $priority = 'medium';

    // Reglas de validación estándar de Laravel
    protected array $rules = [
        'subject' => 'required|string|min:5|max:255',
        'description' => 'required|string|min:10',
        'priority' => 'required|in:low,medium,high',
    ];

    public function save(CreateTicketAction $action)
    {
        $this->validate();

        // 1. Empaquetamos los datos en el DTO
        $dto = new CreateTicketData(
            subject: $this->subject,
            description: $this->description,
            priority: $this->priority,
            userId: Auth::user()->id // El ID del usuario logueado actualmente
        );

        // 2. Ejecutamos la acción del Dominio
        $action->handle($dto);

        // 3. Emitimos un evento para avisar al componente hermano (TicketList) que hay datos nuevos
        $this->dispatch('ticket-created');

        // 4. Limpiamos el formulario
        $this->reset(['subject', 'description', 'priority']);

        // Mensaje flash temporal
        session()->flash('success', '¡Ticket abierto con éxito!');
    }

    public function render()
    {
        return view('livewire.ticket.create-ticket');
    }
}