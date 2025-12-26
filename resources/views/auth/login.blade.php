<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('img/Logo_FondoBlanco.svg') }}" alt="Logo" class="w-72 h-auto">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg animate-fade-in-up">
                {{ session('error') }}
            </div>
        @endif

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200 animate-fade-in-up">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="transform transition-all duration-300 hover:translate-x-1">
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-semibold" />
                <x-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="tu@email.com" />
            </div>

            <div class="transform transition-all duration-300 hover:translate-x-1">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>

            <div class="block transform transition-all duration-300 hover:translate-x-1">
                <label for="remember_me" class="flex items-center cursor-pointer">
                    <x-checkbox id="remember_me" name="remember" class="transition-all duration-300" />
                    <span class="ms-2 text-sm text-gray-700 font-medium">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between pt-2">
                @if (Route::has('password.request'))
                    <a class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-all duration-300 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="transform transition-all duration-300">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
