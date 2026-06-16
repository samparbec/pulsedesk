<?php

namespace App\Livewire\User;

use App\Domains\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTeam extends Component
{
    use WithPagination;

    // Control del modal con Alpine/Livewire
    public bool $isOpen = false;

    // Propiedades del formulario para el nuevo usuario
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'agent'; // Por defecto agente de soporte

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|in:admin,agent,customer',
    ];

    #[\Livewire\Attributes\On('open-manage-team-modal')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        // 🏢 LA MAGIA TENANT: Capturamos la compañía del admin logueado
        $adminCompanyId = Auth::user()->company_id;

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'company_id' => $adminCompanyId, // Se amarra de forma totalmente segura
        ]);

        $this->reset(['name', 'email', 'password', 'role']);
        $this->isOpen = false;

        $this->dispatch('member-added');
        session()->flash('success', '¡Miembro añadido al equipo con éxito!');
    }

    public function render()
    {
        // 🔍 Listamos solo los usuarios de la misma compañía (Multi-tenant)
        // Nota: Si ya tienes el Trait BelongsToCompany en el modelo User, el Scope se encargará de esto solo.
        // Por seguridad, lo forzamos aquí con un where por si acaso.
        $team = User::where('company_id', Auth::user()->company_id)
            ->latest()
            ->paginate(5);

        return view('livewire.user.manage-team', [
            'team' => $team
        ])->layout('layouts.app');
    }
}