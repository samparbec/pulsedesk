<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight tracking-tight">
            {{ __('Panel General') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/70 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <livewire:ticket.create-ticket />

            <livewire:ticket.ticket-list />
            
        </div>
    </div>
</x-app-layout>