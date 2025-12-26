<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6 text-sm text-gray-700 bg-purple-50 p-4 rounded-lg border border-purple-100">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            <div class="transform transition-all duration-300 hover:translate-x-1">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" autofocus placeholder="••••••••" />
            </div>

            <div class="flex justify-end pt-2">
                <x-button class="transform transition-all duration-300">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
