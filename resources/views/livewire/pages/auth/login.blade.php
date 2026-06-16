<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full sm:max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden p-8 transition-all duration-300">
    
    <!-- Identidad de Marca dentro de la tarjeta -->
    <div class="flex flex-col items-center justify-center mb-8">
        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mb-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            Pulse<span class="text-indigo-600">Desk</span>
        </h2>
        <p class="text-xs text-slate-400 mt-1 font-medium">Inicia sesión en tu portal de soporte</p>
    </div>

    <!-- Status de sesión (Ej. si se recuperó contraseña) -->
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Correo Electrónico -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Correo Electrónico</label>
            <div class="relative">
                <input wire:model="form.email" 
                       id="email" 
                       type="email" 
                       name="email" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="nombre@empresa.com"
                       class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-3">
            </div>
            @error('form.email') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <!-- Contraseña -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition" href="{{ route('password.request') }}" wire:navigate>
                        ¿La olvidaste?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input wire:model="form.password" 
                       id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password" 
                       placeholder="••••••••"
                       class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-3">
            </div>
            @error('form.password') <span class="inline-block text-xs font-semibold text-red-600 mt-1.5 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <!-- Recuérdame -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" 
                       id="remember" 
                       type="checkbox" 
                       class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500/20 w-4 h-4 transition duration-150 ease-in-out" 
                       name="remember">
                <span class="ms-2 text-xs font-semibold text-slate-500">{{ __('Recuérdame en este equipo') }}</span>
            </label>
        </div>

        <!-- Botón de Envío -->
        <div class="pt-2">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                
                <span wire:loading.remove wire:target="login">
                    {{ __('Entrar al Panel') }}
                </span>

                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Cargando...') }}
                </span>
            </button>
        </div>
    </form>
</div>