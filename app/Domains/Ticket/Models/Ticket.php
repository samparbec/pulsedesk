<?php

namespace App\Domains\Ticket\Models;

use App\Domains\User\Models\User; 
use App\Shared\Traits\BelongsToCompany;
use App\Domains\Ticket\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use BelongsToCompany;

    protected $fillable = ['subject', 'description', 'status', 'priority', 'user_id', 'assigned_to'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }
}