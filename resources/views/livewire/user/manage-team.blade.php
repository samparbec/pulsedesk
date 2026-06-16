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
                
                <button x-data 
                        x-on:click="$dispatch('open-manage-team-modal')" 
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
                            <th class="px-6 py-4 text-right">Fecha de Alta</th>
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
                                    @if($member->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-purple-700 bg-purple-50 rounded-lg border border-purple-100">Administrador</span>
                                    @elseif($member->role === 'agent')
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-indigo-700 bg-indigo-50 rounded-lg border border-indigo-100">Agente Soporte</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-slate-600 bg-slate-50 rounded-lg border border-slate-200">Cliente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4.5 text-right text-xs font-medium text-gray-400">{{ $member->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">No hay más miembros en tu equipo.</td>
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
             x-on:open-manage-team-modal.window="show = true" 
             x-on:member-added.window="show = false"
             class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" x-on:click="show = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50/50 to-white">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 tracking-tight">Dar de alta en la Organización</h3>
                            <p class="text-xs text-gray-500 mt-0.5">El usuario se vinculará a tu empresa automáticamente</p>
                        </div>
                        <button x-on:click="show = false" class="text-gray-400 hover:text-gray-600 text-xl font-medium">&times;</button>
                    </div>

                    <form wire:submit="save" class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                            <input type="text" wire:model="name" placeholder="Ej. Juan Pérez" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('name') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                            <input type="email" wire:model="email" placeholder="juan@empresa.com" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('email') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña Temporal</label>
                            <input type="password" wire:model="password" placeholder="Mínimo 8 caracteres" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5">
                            @error('password') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Rol de Sistema</label>
                            <select wire:model="role" class="block w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5 bg-slate-50 font-medium text-slate-700">
                                <option value="agent">👨‍💻 Agente de Soporte</option>
                                <option value="customer">🏢 Cliente Final (Customer)</option>
                                <option value="admin">🔑 Administrador de Empresa</option>
                            </select>
                            @error('role') <span class="text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 rounded-md">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                            <button type="button" x-on:click="show = false" class="px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">Cancelar</button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md">Registrar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>