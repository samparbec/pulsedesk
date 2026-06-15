<?php

namespace App\Models\Domains\Ticket\Models;

use App\Domains\User\Models\User;
use App\Shared\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use BelongsToCompany;

    protected $fillable = ['subject', 'description', 'status', 'priority', 'assigned_to'];

    // Relación: Quién creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Agente asignado (puede ser null)
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
