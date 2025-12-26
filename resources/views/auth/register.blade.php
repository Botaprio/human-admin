<x-guest-layout>
                        <x-authentication-card>
                            <x-slot name="logo">
                                <img src="{{ asset('img/Logo_FondoBlanco.svg') }}" alt="Logo" class="w-72 h-auto">
                            </x-slot>

                            <x-validation-errors class="mb-4" />

                            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                                @csrf

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="transform transition-all duration-300 hover:translate-x-1">
                                        <x-label for="first_name" value="Primer Nombre" class="text-gray-700 font-semibold" />
                                        <x-input id="first_name" class="block mt-2 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" placeholder="Juan" />
                                    </div>

                                    <div class="transform transition-all duration-300 hover:translate-x-1">
                                        <x-label for="second_name" value="Segundo Nombre" class="text-gray-700 font-semibold" />
                                        <x-input id="second_name" class="block mt-2 w-full" type="text" name="second_name" :value="old('second_name')" autocomplete="additional-name" placeholder="Carlos" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="transform transition-all duration-300 hover:translate-x-1">
                                        <x-label for="last_name" value="Primer Apellido" class="text-gray-700 font-semibold" />
                                        <x-input id="last_name" class="block mt-2 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" placeholder="Pérez" />
                                    </div>

                                    <div class="transform transition-all duration-300 hover:translate-x-1">
                                        <x-label for="second_last_name" value="Segundo Apellido" class="text-gray-700 font-semibold" />
                                        <x-input id="second_last_name" class="block mt-2 w-full" type="text" name="second_last_name" :value="old('second_last_name')" autocomplete="additional-name" placeholder="García" />
                                    </div>
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <x-label for="email" value="Correo Electrónico" class="text-gray-700 font-semibold" />
                                    <x-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="tu@email.com" />
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <x-label for="password" value="Contraseña" class="text-gray-700 font-semibold" />
                                    <x-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                                </div>

                                <div class="transform transition-all duration-300 hover:translate-x-1">
                                    <x-label for="password_confirmation" value="Confirmar Contraseña" class="text-gray-700 font-semibold" />
                                    <x-input id="password_confirmation" class="block mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <a class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-all duration-300 hover:underline" href="{{ route('login') }}">
                                        ¿Ya estás registrado?
                                    </a>
                                    <div class="hidden">
                                        <x-input id="rol" type="hidden" name="rol" value="admin" />
                                    </div>
                                    <x-button class="transform transition-all duration-300">
                                        Registrarse
                                    </x-button>
                                </div>
                            </form>
                        </x-authentication-card>
                    </x-guest-layout>
