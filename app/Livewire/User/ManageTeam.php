<?php

namespace App\Livewire\User;

use App\Domains\User\Models\User;
use App\Domains\User\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTeam extends Component
{
    use WithPagination;

    public bool $isOpen = false;
    public bool $isEditing = false;
    public ?int $userId = null;

    // Propiedades del formulario
    public string $name = '';
    public string $email = '';
    public string $password = '';
    
    // 🟢 CAMBIO: Ahora es un array para guardar múltiples IDs de roles
    public array $selectedRoles = []; 

    public function mount()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permisos para administrar el equipo.');
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'password' => $this->isEditing ? 'nullable|string|min:8' : 'required|string|min:8',
            'selectedRoles' => 'required|array|min:1', // Obligatorio elegir al menos 1 rol
            'selectedRoles.*' => 'exists:roles,id',     // Validamos que los IDs existan
        ];
    }

    protected function messages()
    {
        return [
            'selectedRoles.required' => 'Debes asignar al menos un rol a este usuario.',
        ];
    }

    #[\Livewire\Attributes\On('open-manage-team-modal')]
    public function openModalForCreate()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'selectedRoles', 'userId', 'isEditing']);
        
        // Al crear, podemos preseleccionar el rol de agente por defecto buscándolo en la BD
        $agentRole = Role::where('name', 'agent')->first();
        if ($agentRole) {
            $this->selectedRoles = [$agentRole->id];
        }

        $this->isOpen = true;
    }

    public function edit(int $id)
    {
        $this->resetValidation();
        $this->isEditing = true;
        $this->userId = $id;

        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        
        // 🔄 Cargamos TODOS los IDs de los roles que ya tiene asignados el usuario
        $this->selectedRoles = $user->roles->pluck('id')->toArray();

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    protected function createUser()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'company_id' => Auth::user()->company_id,
        ]);

        // 🔄 Sincronizamos el array de IDs directos con la tabla pivote
        $user->roles()->sync($this->selectedRoles);

        session()->flash('success', '¡Miembro añadido al equipo con éxito!');
        $this->closeModal();
    }

    protected function updateUser()
    {
        $user = User::findOrFail($this->userId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        // 🔄 Sincronizamos los nuevos roles (añade los nuevos y borra los desmarcados)
        $user->roles()->sync($this->selectedRoles);

        session()->flash('success', '¡Miembro actualizado con éxito!');
        $this->closeModal();
    }

    protected function closeModal()
    {
        $this->isOpen = false;
        $this->dispatch('member-processed');
    }

    public function render()
    {
        $team = User::where('company_id', Auth::user()->company_id)
            ->with('roles') 
            ->latest()
            ->paginate(5);

        // Pasamos todos los roles de la base de datos a la vista para pintar los checkboxes
        return view('livewire.user.manage-team', [
            'team' => $team,
            'allRoles' => Role::all() 
        ])->layout('layouts.app');
    }
}