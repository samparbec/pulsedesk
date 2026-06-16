<?php

namespace App\Livewire\Ticket;

use App\Domains\Ticket\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTicket extends Component
{
    public Ticket $ticket;

    public string $commentText = '';
    
    public string $status;

    protected array $rules = [
        'commentText' => 'required|string|min:3',
        'status' => 'required|in:open,in_progress,resolved,closed',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->status = $ticket->status;
    }

    public function updateStatus()
    {
        $this->validateOnly('status');
        
        $this->ticket->update([
            'status' => $this->status
        ]);

        session()->flash('status-updated', 'Estado del ticket actualizado.');
    }

    public function addComment()
    {
        $this->validateOnly('commentText');

        // Suponiendo que tienes una relación 'comments' en tu modelo Ticket.
        // Si aún no la tenemos creada en el modelo, la crearemos en el siguiente paso.
        $this->ticket->comments()->create([
            'content' => $this->commentText,
            'user_id' => Auth::user()->id,
        ]);

        $this->reset('commentText');
        $this->ticket->refresh(); // Refrescamos el modelo para que pinte el nuevo comentario
    }

    public function render()
    {        
        return view('livewire.ticket.show-ticket')->layout('layouts.app');;
    }
}