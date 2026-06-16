<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full sm:max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden p-8 transition-all duration-300">
    
    <div class="flex flex-col items-center justify-center mb-6">
        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mb-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            Pulse<span class="text-indigo-600">Desk</span>
        </h2>
        <p class="text-xs text-slate-400 mt-1 font-medium">Crea una cuenta de agente de soporte</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div>
            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre Completo</label>
            <input wire:model="name" 
                   id="name" 
                   type="text" 
                   name="name" 
                   required 
                   autofocus 
                   autocomplete="name" 
                   placeholder="Tu nombre y apellidos"
                   class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-2.5">
            @error('name') <span class="inline-block text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
            <input wire:model="email" 
                   id="email" 
                   type="email" 
                   name="email" 
                   required 
                   autocomplete="username" 
                   placeholder="nombre@empresa.com"
                   class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-2.5">
            @error('email') <span class="inline-block text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña</label>
            <input wire:model="password" 
                   id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password" 
                   placeholder="••••••••"
                   class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-2.5">
            @error('password') <span class="inline-block text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Confirmar Contraseña</label>
            <input wire:model="password_confirmation" 
                   id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password" 
                   placeholder="••••••••"
                   class="block w-full rounded-xl border-gray-200 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500/20 transition-all duration-200 py-2.5">
            @error('password_confirmation') <span class="inline-block text-xs font-semibold text-red-600 mt-1 bg-red-50 px-2 py-0.5 rounded-md">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition" href="{{ route('login') }}" wire:navigate>
                ¿Ya tienes cuenta?
            </a>

            <button type="submit" 
                    class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition-all duration-200 shadow-md shadow-indigo-100">
                {{ __('Registrarme') }}
            </button>
        </div>
    </form>
</div>