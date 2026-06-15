<?php

namespace App\Domains\Ticket\Actions;

use App\Domains\Ticket\Models\Ticket;
use App\Domains\Ticket\DTOs\CreateTicketData;
use App\Domains\Ticket\Enums\TicketStatus;

class CreateTicketAction
{
    public function handle(CreateTicketData $data): Ticket
    {
        // Nota: El 'company_id' se inyectará solo gracias al Trait BelongsToCompany
        return Ticket::create([
            'user_id' => $data->userId,
            'subject' => $data->subject,
            'description' => $data->description,
            'priority' => $data->priority,
            'status' => TicketStatus::Open->value, // Todo ticket arranca abierto
            'assigned_to' => $data->assignedTo,
        ]);
    }
}