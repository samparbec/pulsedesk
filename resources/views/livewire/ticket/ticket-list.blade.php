<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300">
    
    <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
        <div>
            <h2 class="text-lg font-bold text-gray-900 tracking-tight">Tickets de Soporte</h2>
            <p class="text-xs text-gray-500 mt-0.5">Gestiona y monitoriza las incidencias en tiempo real</p>
        </div>
        
        <button x-data 
                x-on:click="$dispatch('open-create-ticket-modal')" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-sm shadow-indigo-100 hover:shadow-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Ticket
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 whitespace-nowrap">
            <thead class="text-xs text-gray-400 font-bold uppercase tracking-wider bg-gray-50/75 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4">Asunto e Incidencia</th>
                    <th class="px-6 py-4">Creado Por</th>
                    <th class="px-6 py-4 text-center">Prioridad</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Fecha de Apertura</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                        
                        <td class="px-6 py-4.5">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-150">
                                    {{ $ticket->subject }}
                                </span>
                                <span class="text-xs text-gray-400 max-w-md truncate mt-0.5">
                                    {{ Str::limit($ticket->description, 60) }}
                                </span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 bg-gradient-to-br from-indigo-100 to-indigo-50 text-indigo-700 font-bold rounded-lg text-xs flex items-center justify-center shadow-inner">
                                    {{ strtoupper(substr($ticket->user->name, 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-700">{{ $ticket->user->name }}</span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4.5 text-center">
                            @if($ticket->priority === 'high')
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-red-700 bg-red-50 rounded-lg border border-red-100">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                    Alta
                                </span>
                            @elseif($ticket->priority === 'medium')
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-amber-700 bg-amber-50 rounded-lg border border-amber-100">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-amber-500"></span>
                                    Media
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-lg border border-emerald-100">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span>
                                    Baja
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4.5 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50/60 rounded-lg border border-indigo-100/50 uppercase tracking-wider">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4.5 text-right font-medium text-gray-500 text-xs">
                            {{ $ticket->created_at->format('d M, Y • H:i') }}
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                <p class="text-gray-400 font-medium">No hay tickets registrados en esta compañía.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $tickets->links() }}
        </div>
    @endif
</div>