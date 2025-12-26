<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-6 text-sm text-gray-700 bg-purple-50 p-4 rounded-lg border border-purple-100 transition-all duration-300" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-6 text-sm text-gray-700 bg-purple-50 p-4 rounded-lg border border-purple-100 transition-all duration-300" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
                @csrf

                <div class="transform transition-all duration-300 hover:translate-x-1" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" class="text-gray-700 font-semibold" />
                    <x-input id="code" class="block mt-2 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" placeholder="000000" />
                </div>

                <div class="transform transition-all duration-300 hover:translate-x-1" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" class="text-gray-700 font-semibold" />
                    <x-input id="recovery_code" class="block mt-2 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" placeholder="XXXXX-XXXXX" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="button" class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-all duration-300 hover:underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-purple-600 hover:text-purple-800 font-medium transition-all duration-300 hover:underline cursor-pointer"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="transform transition-all duration-300">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
