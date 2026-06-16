<div class="py-12 bg-slate-50/70 min-h-[calc(100vh-65px)]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm font-bold text-emerald-700 bg-emerald-50 rounded-xl border border-emerald-100 flex items-center gap-2 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 tracking-tight">Miembros de la Organización</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Gestiona los accesos y roles del personal de tu compañía</p>
                </div>
                
                <button wire:click="openModalForCreate" 
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-sm shadow-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Añadir Miembro
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
                    <thead class="text-xs text-gray-400 font-bold uppercase tracking-wider bg-gray-50/75 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Usuario</th>
                            <th class="px-6 py-4">Correo Electrónico</th>
                            <th class="px-6 py-4 text-center">Rol asignado</th>
                            <th class="px-6 py-4 text-center">Fecha de Alta</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($team as $member)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                <td class="px-6 py-4.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-indigo-500 text-white font-bold rounded-xl text-xs flex items-center justify-center shadow-md shadow-indigo-100">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4.5 font-medium text-gray-600">{{ $member->email }}</td>
                                <td class="px-6 py-4.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                        @forelse($member->roles as $role)
                                            @if($role->name === 'admin')
                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-purple-700 bg-purple-50 rounded-lg border border-purple-100">Administrador</span>
                                            @elseif($role->name === 'agent')
                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-indigo-700 bg-indigo-50 rounded-lg border border-indigo-100">Agente Soporte</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-slate-600 bg-slate-50 rounded-lg border border-slate-200">Cliente</span>
                                            @endif
                                        @empty
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-red-600 bg-red-50 rounded-lg border border-red-100">Sin Rol</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4.5 text-center text-xs font-medium text-gray-400">{{ $member->created_at->format('d M, Y') }}</td>
                                <td class="px-6 py-4.5 text-right">
                                    <button wire:click="edit({{ $member->id }})" class="p-1.5 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all duration-150" title="Editar Miembro">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">No hay más miembros en tu equipo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($team->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">{{ $team->links() }}</div>
            @endif
        </div>

        <div x-data="{ show: $wire.entangle('isOpen') }" 
             x-show="show" 
             x-on:member-processed.window="show = false"
             class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" x-on:click="show = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50/50 to-white">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 tracking-tight">
                                {{ $isEditing ? 'Modificar perfil de miembro' : 'Dar de alta en la Organización' }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $isEditing ? 'Los cambios se aplicarán al instante' : 'El usuario se vinculará a tu empresa automáticamente' }}
                            </p>
                        </div>
                        <button type="button" x-on:click="show = false" class="text-gray-400 hover:text-gray-600 text-xl font-medium">&times;</button>
                    </div>

                    <form wire:submit="save" class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                            <input type="text" wire:model="name" placeholder="Ej. Juan Pérez" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('name') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md block w-fit">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                            <input type="email" wire:model="email" placeholder="juan@empresa.com" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('email') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md block w-fit">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex items-baseline justify-between mb-1.5">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Contraseña</label>
                                @if($isEditing)
                                    <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Dejar en blanco para no cambiar</span>
                                @endif
                            </div>
                            <input type="password" wire:model="password" placeholder="{{ $isEditing ? 'Nueva contraseña (opcional)' : 'Mínimo 8 caracteres' }}" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('password') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md block w-fit">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Roles asignados (Selección múltiple)</label>
                            
                            <div class="grid grid-cols-1 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                @foreach($allRoles as $roleOption)
                                    <label class="flex items-center gap-3 px-3 py-2.5 bg-white rounded-lg border border-slate-200/60 hover:border-indigo-200 cursor-pointer transition duration-150 group">
                                        <input type="checkbox" 
                                            wire:model="selectedRoles" 
                                            value="{{ $roleOption->id }}"
                                            class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500/20 w-4 h-4 transition duration-150">
                                        
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-800 group-hover:text-slate-900">
                                                @if($roleOption->name === 'admin') 🔑 Admin @elseif($roleOption->name === 'agent') 👨‍💻 Agente @else 🏢 Cliente @endif 
                                                <span class="font-medium text-slate-700">- {{ $roleOption->label }}</span>
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedRoles') <span class="text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 rounded-md block w-fit">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                            <button type="button" x-on:click="show = false" class="px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">Cancelar</button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md">
                                {{ $isEditing ? 'Guardar Cambios' : 'Registrar Usuario' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>