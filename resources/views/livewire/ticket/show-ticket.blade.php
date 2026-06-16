<div class="py-10 bg-slate-50/70 min-h-[calc(100vh-65px)]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors duration-150 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al panel general
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-slate-50/50 to-white">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ticket #{{ $ticket->id }}</span>
                            @if($ticket->priority === 'high')
                                <span class="px-2 py-0.5 text-[10px] font-bold text-red-700 bg-red-50 border border-red-100 rounded-md">Alta</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-100 rounded-md">Media</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-md">Baja</span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold text-slate-400">{{ $ticket->created_at->format('d M, Y • H:i') }}</span>
                    </div>
                    
                    <div class="p-6">
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight mb-3">{{ $ticket->subject }}</h1>
                        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider px-1">Historial de Actividad</h3>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <form wire:submit="addComment" class="space-y-4">
                            <div>
                                <textarea wire:model="commentText" 
                                          rows="3" 
                                          placeholder="Escribe una respuesta o actualización sobre esta incidencia..."
                                          class="block w-full rounded-xl border-slate-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200"></textarea>
                                @error('commentText') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-sm shadow-indigo-100">
                                    Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="space-y-4" wire:poll.10s>
                        @forelse($ticket->comments as $comment)
                            <div class="flex gap-4 p-5 bg-white rounded-2xl shadow-sm border border-slate-100 transition-all duration-150">
                                <div class="shrink-0 w-8 h-8 ...">
                                    {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 space-y-1">
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-sm font-bold text-slate-900">{{ $comment->user->name }}</span>
                                        <span class="text-[11px] font-medium text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-slate-50 border border-dashed border-slate-200 rounded-2xl">
                                <p class="text-xs text-slate-400 font-medium">No hay respuestas ni notas en este ticket todavía.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Estado del Ticket</h4>
                        
                        <select wire:model.live="status" 
                                wire:change="updateStatus"
                                class="block w-full rounded-xl border-slate-200 text-sm font-semibold text-slate-700 bg-slate-50 focus:border-indigo-500 focus:ring-indigo-500/20 py-2.5 cursor-pointer">
                            <option value="open">🟢 Abierto (Open)</option>
                            <option value="in_progress">🟡 En Progreso</option>
                            <option value="resolved">🔵 Resuelto</option>
                            <option value="closed">🔴 Cerrado</option>
                        </select>
                    </div>

                    @if (session()->has('status-updated'))
                        <div class="p-2.5 text-center text-[11px] font-bold text-emerald-700 bg-emerald-50 rounded-lg border border-emerald-100 animate-fade-in">
                            {{ session('status-updated') }}
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-2">Información de Origen</h4>
                    
                    <div class="space-y-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 bg-indigo-50 text-indigo-700 font-bold rounded-lg text-xs flex items-center justify-center">
                                {{ strtoupper(substr($ticket->user->name, 0, 2)) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800">{{ $ticket->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $ticket->user->email }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-50/60">
                            <span class="font-medium text-slate-400">Compañía / Cliente</span>
                            <span class="font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md uppercase tracking-wider text-[10px]">
                                {{ $ticket->user->company->name ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>