<?php

namespace App\Livewire\Ticket;

use App\Domains\Ticket\Actions\CreateTicketAction;
use App\Domains\Ticket\DTOs\CreateTicketData;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTicket extends Component
{
    public bool $isOpen = false;

    // Form state binding
    public string $subject = '';
    public string $description = '';
    public string $priority = 'medium';

    // Validation rules
    protected array $rules = [
        'subject' => 'required|string|min:5|max:255',
        'description' => 'required|string|min:10',
        'priority' => 'required|in:low,medium,high',
    ];

    public function save(CreateTicketAction $action)
    {
        $this->validate();
        
        $dto = new CreateTicketData(
            subject: $this->subject,
            description: $this->description,
            priority: $this->priority,
            userId: Auth::id()
        );

        $action->handle($dto);
        $this->dispatch('ticket-created');
        $this->reset(['subject', 'description', 'priority']);
        
        session()->flash('success', '¡Ticket abierto con éxito!');
    }

    public function render()
    {
        return view('livewire.ticket.create-ticket');
    }
}