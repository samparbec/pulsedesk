<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between transition-all duration-200 hover:shadow-md hover:border-slate-200/60">
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Incidencias</span>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $metrics['total'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-slate-50 text-slate-500 rounded-xl flex items-center justify-center border border-slate-100 shrink-0 ml-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between transition-all duration-200 hover:shadow-md hover:border-slate-200/60">
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">🟢 Abiertos</span>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $metrics['open'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center border border-emerald-100/50 shrink-0 ml-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between transition-all duration-200 hover:shadow-md hover:border-slate-200/60">
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">🟡 En Progreso</span>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $metrics['in_progress'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center border border-amber-100/50 shrink-0 ml-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.213 6H16"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center justify-between transition-all duration-200 hover:shadow-md hover:border-slate-200/60">
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">🔵 Resueltos</span>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $metrics['resolved'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center border border-indigo-100/50 shrink-0 ml-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

    </div>
    
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
                                <a href="{{ route('tickets.show', $ticket) }}" wire:navigate class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-150 cursor-pointer">
                                    {{ $ticket->subject }}
                                </a>
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