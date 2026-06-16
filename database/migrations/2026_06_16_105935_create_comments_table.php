<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->text('content'); // El cuerpo del mensaje/respuesta
            
           
            $blueprint->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};