<?php

namespace App\Domains\Ticket\DTOs;

class CreateTicketData
{
    public function __construct(
        public string $subject,
        public string $description,
        public string $priority,
        public int $userId,
        public ?int $assignedTo = null,
    ) {}
}