<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla de Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'admin', 'agent', 'customer'
            $table->string('label')->nullable(); // 'Administrador', 'Agente Soporte' (para pintar bonito)
            $table->timestamps();
        });

        // 2. Tabla Pivote Many-to-Many (Muchos a Muchos)
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Apuntamos a la tabla de roles de forma segura
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            
            $table->timestamps();

            // Evitamos duplicados: un usuario no puede tener el mismo rol repetido dos veces
            $table->unique(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};