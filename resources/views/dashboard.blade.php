<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-purple-50 via-white to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-fade-in-up">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card principal con gradiente -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100 transform transition-all duration-300 hover:shadow-purple-200">
                
                <!-- Header con gradiente -->
                <div class="bg-gradient-to-r from-purple-600 via-purple-500 to-indigo-600 px-8 py-6">
                    <div class="flex items-center justify-between flex-col md:flex-row gap-4">
                        <!-- Logo a la izquierda -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('img/Logo_FondoOscuro.svg') }}" alt="Logo" class="h-16 w-auto">
                        </div>

                        <!-- Texto a la derecha -->
                        <div class="w-full md:w-auto text-center md:text-right">
                            <h3 class="text-3xl font-bold text-white">
                                Registrar Nuevo Usuario
                            </h3>
                            <p class="text-purple-100 mt-1">Complete el formulario para crear una nueva cuenta de usuario</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="px-8 py-10">
                    <x-validation-errors class="mb-6"/>

                    <form method="POST" action="{{ route('dashboard.register-user') }}" class="space-y-8">
                        @csrf

                        <!-- Nombres -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="bg-purple-100 text-purple-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Información Personal
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Primer Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                           autocomplete="given-name" placeholder="Juan"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="second_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Segundo Nombre
                                    </label>
                                    <input id="second_name" type="text" name="second_name" value="{{ old('second_name') }}"
                                           autocomplete="additional-name" placeholder="Carlos"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Primer Apellido <span class="text-red-500">*</span>
                                    </label>
                                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                                           autocomplete="family-name" placeholder="Pérez"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="second_last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Segundo Apellido
                                    </label>
                                    <input id="second_last_name" type="text" name="second_last_name" value="{{ old('second_last_name') }}"
                                           autocomplete="additional-name" placeholder="García"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Email y Rol -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="bg-purple-100 text-purple-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Credenciales de Acceso
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Electrónico <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                               placeholder="usuario@ejemplo.com"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                    </div>
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="rol" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Rol del Usuario <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </div>
                                        <select id="rol" name="rol" required
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg appearance-none bg-white cursor-pointer">
                                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>👑 Administrador</option>
                                            <option value="profesional" {{ old('rol', 'profesional') == 'profesional' ? 'selected' : '' }}>💼 Profesional</option>
                                            <option value="empresa" {{ old('rol') == 'empresa' ? 'selected' : '' }}>🏢 Empresa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contraseñas -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="bg-purple-100 text-purple-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">3</span>
                                Seguridad
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input id="password" type="password" name="password" required autocomplete="new-password"
                                               placeholder="••••••••"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmar Contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <input id="password_confirmation" type="password" name="password_confirmation" required
                                               autocomplete="new-password" placeholder="••••••••"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de envío -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Registrar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</x-app-layout>
