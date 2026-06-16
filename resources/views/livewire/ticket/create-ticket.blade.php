<div x-data="{ show: $wire.entangle('isOpen') }" 
     x-show="show" 
     x-on:open-create-ticket-modal.window="show = true" 
     x-on:ticket-created.window="show = false"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/40 backdrop-blur-md" x-on:click="show = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
            
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-slate-50/50 to-white">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Abrir Nuevo Ticket</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Describe la incidencia para asignarla al equipo de soporte</p>
                </div>
                <button x-on:click="show = false" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors duration-150 font-medium text-xl">
                    &times;
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-5">
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Asunto de la Incidencia</label>
                    <div class="relative rounded-xl shadow-sm">
                        <input type="text" 
                               wire:model="subject" 
                               placeholder="Ej. Error al conectar la impresora de red"
                               class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-3">
                    </div>
                    @error('subject') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Descripción Detallada</label>
                    <textarea wire:model="description" 
                              rows="4" 
                              placeholder="Por favor, incluye capturas de error o pasos para reproducir el problema..."
                              class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200"></textarea>
                    @error('description') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nivel de Prioridad</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer border rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all duration-200 {{ $priority === 'low' ? 'border-emerald-500 bg-emerald-50/40 text-emerald-700 font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                            <input type="radio" wire:model.live="priority" value="low" class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-xs">Baja</span>
                        </label>
                        <label class="cursor-pointer border rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all duration-200 {{ $priority === 'medium' ? 'border-amber-500 bg-amber-50/40 text-amber-700 font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                            <input type="radio" wire:model.live="priority" value="medium" class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="text-xs">Media</span>
                        </label>
                        <label class="cursor-pointer border rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all duration-200 {{ $priority === 'high' ? 'border-red-500 bg-red-50/40 text-red-700 font-bold' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                            <input type="radio" wire:model.live="priority" value="high" class="sr-only">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-xs">Alta</span>
                        </label>
                    </div>
                    @error('priority') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" 
                            x-on:click="show = false" 
                            class="px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all duration-150">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-md shadow-indigo-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Crear Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>