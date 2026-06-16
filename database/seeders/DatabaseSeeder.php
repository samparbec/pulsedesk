<?php

namespace Database\Seeders;

use App\Domains\Company\Models\Company;
use App\Domains\Ticket\Models\Ticket;
use App\Domains\Ticket\Enums\TicketStatus;
use App\Domains\Ticket\Enums\TicketPriority;
use Database\Factories\UserFactory; // <-- Asegúrate de importar la Factory aquí arriba
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🏢 TENANT 1: CREAR EMPRESA ALFA
        $companyAlfa = Company::create([
            'name' => 'Empresa Alfa',
            'slug' => 'alfa',
        ]);

        // 👤 Crear Admin de Empresa Alfa usando la Factory directamente
        $userAlfa = UserFactory::new()->create([
            'company_id' => $companyAlfa->id,
            'name' => 'Soporte Alfa',
            'email' => 'alfa@example.com',
            'password' => Hash::make('password'),
        ]);

        // 🎫 Crear Tickets para Empresa Alfa
        Ticket::create([
            'company_id' => $companyAlfa->id,
            'user_id' => $userAlfa->id,
            'subject' => 'No funciona la impresora en Alfa',
            'description' => 'La impresora del departamento de administración no responde a la red.',
            'status' => TicketStatus::Open->value,
            'priority' => TicketPriority::High->value,
        ]);


        // 🏢 TENANT 2: CREAR EMPRESA BETA
        $companyBeta = Company::create([
            'name' => 'Empresa Beta',
            'slug' => 'beta',
        ]);

        // 👤 Crear Admin de Empresa Beta usando la Factory directamente
        $userBeta = UserFactory::new()->create([
            'company_id' => $companyBeta->id,
            'name' => 'Soporte Beta',
            'email' => 'beta@example.com',
            'password' => Hash::make('password'),
        ]);

        // 🎫 Crear Ticket para Empresa Beta
        Ticket::create([
            'company_id' => $companyBeta->id,
            'user_id' => $userBeta->id,
            'subject' => 'Error de login en Beta',
            'description' => 'Un usuario de Beta no puede restablecer su contraseña.',
            'status' => TicketStatus::Open->value,
            'priority' => TicketPriority::Medium->value,
        ]);

        $this->call([
            RoleSeeder::class,
        ]);
    }
}