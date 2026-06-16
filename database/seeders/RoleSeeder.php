<?php

namespace Database\Seeders;

use App\Domains\User\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Administrador'],
            ['name' => 'agent', 'label' => 'Agente Soporte'],
            ['name' => 'customer', 'label' => 'Cliente Final'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], ['label' => $role['label']]);
        }
    }
}