<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 sticky top-0 z-40 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo PulseDesk Adaptado a Fondo Oscuro -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-900/50 group-hover:bg-indigo-500 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <!-- ARREGLADO: Cambiado text-slate-900 por text-white -->
                        <span class="text-lg font-black text-white tracking-tight group-hover:text-indigo-400 transition-colors duration-200">
                            Pulse<span class="text-indigo-400 group-hover:text-white">Desk</span>
                        </span>
                    </a>
                </div>

                <!-- Enlaces de Navegación Adaptados -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Modificamos las clases del componente interno para que use texto blanco/gris claro -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="font-semibold text-sm tracking-wide text-slate-300 hover:text-white border-indigo-400">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('team')" :active="request()->routeIs('team')" wire:navigate class="font-semibold text-sm tracking-wide text-slate-300 hover:text-white border-indigo-400">
                        {{ __('Mi Equipo') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown Adaptado -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- ARREGLADO: Botón cambiado a bg-slate-800 y texto slate-200 -->
                        <button class="inline-flex items-center gap-2.5 px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-xl text-slate-200 bg-slate-800 hover:text-white hover:bg-slate-750 focus:outline-none transition-all duration-200">
                            <div class="w-6 h-6 bg-indigo-600 text-white rounded-md text-[10px] font-bold flex items-center justify-center shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name" class="text-xs"></div>

                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-indigo-300 bg-indigo-950/50 border border-indigo-900 rounded-md uppercase tracking-wider">
                                {{ auth()->user()->company->name ?? 'Global' }}
                            </span>

                            <svg class="fill-current h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-3 py-2 text-xs border-b border-slate-100 font-medium text-slate-400">
                            Mi Cuenta
                        </div>
                        
                        <x-dropdown-link :href="route('profile')" wire:navigate class="flex items-center gap-2 text-slate-600 rounded-lg mx-1 my-0.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="flex items-center gap-2 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg mx-1 my-0.5">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Adaptado -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-slate-900 border-t border-slate-800">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="text-slate-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('team')" :active="request()->routeIs('team')" wire:navigate class="text-slate-300">
                {{ __('Mi Equipo') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-800 bg-slate-950/50">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-bold text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-slate-400">{{ auth()->user()->email }}</div>
                </div>
                <span class="px-2.5 py-0.5 text-xs font-bold text-indigo-400 bg-indigo-950/50 border border-indigo-900 rounded-md uppercase tracking-wider">
                    {{ auth()->user()->company->name ?? 'Global' }}
                </span>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile')" wire:navigate class="rounded-xl text-slate-300">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-red-400 hover:bg-red-950/30 rounded-xl">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>