<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Usuario') }}
            </h2>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-300">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <img class="h-20 w-20 rounded-full object-cover ring-4 ring-purple-100" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->rol === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($user->rol) }}
                                    </span>
                                    @if($user->is_suspended)
                                        <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Suspendido
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nombres -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Primer Nombre <span class="text-red-500">*</span>
                                </label>
                                <input id="first_name" 
                                       name="first_name" 
                                       type="text" 
                                       value="{{ old('first_name', $user->first_name) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="second_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Segundo Nombre
                                </label>
                                <input id="second_name" 
                                       name="second_name" 
                                       type="text" 
                                       value="{{ old('second_name', $user->second_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('second_name') border-red-500 @enderror">
                                @error('second_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Primer Apellido <span class="text-red-500">*</span>
                                </label>
                                <input id="last_name" 
                                       name="last_name" 
                                       type="text" 
                                       value="{{ old('last_name', $user->last_name) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="second_last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Segundo Apellido
                                </label>
                                <input id="second_last_name" 
                                       name="second_last_name" 
                                       type="text" 
                                       value="{{ old('second_last_name', $user->second_last_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('second_last_name') border-red-500 @enderror">
                                @error('second_last_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email y Rol -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="transform transition-all duration-300 hover:translate-x-1">
                                <label for="rol" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rol <span class="text-red-500">*</span>
                                </label>
                                <select id="rol" 
                                        name="rol" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('rol') border-red-500 @enderror">
                                    <option value="user" {{ old('rol', $user->rol) === 'user' ? 'selected' : '' }}>Usuario</option>
                                    <option value="admin" {{ old('rol', $user->rol) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('rol')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Cambiar Contraseña -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Contraseña (Opcional)</h4>
                            <p class="text-sm text-gray-600 mb-4">Deja estos campos vacíos si no deseas cambiar la contraseña.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nueva Contraseña
                                    </label>
                                    <input id="password" 
                                           name="password" 
                                           type="password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg @error('password') border-red-500 @enderror"
                                           placeholder="••••••••">
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmar Contraseña
                                    </label>
                                    <input id="password_confirmation" 
                                           name="password_confirmation" 
                                           type="password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 hover:shadow-md focus:shadow-lg"
                                           placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('users.index') }}" 
                               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-all duration-300 transform hover:scale-105">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                💾 Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
