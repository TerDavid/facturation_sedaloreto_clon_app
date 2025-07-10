<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Autenticación de Dos Factores') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Agrega seguridad adicional a tu cuenta usando autenticación de dos factores.') }}
        </p>
    </header>

    @if (! auth()->user()->two_factor_secret)
        {{-- Enable 2FA --}}
        <form method="post" action="{{ url('/user/two-factor-authentication') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-primary-button>{{ __('Habilitar Autenticación de Dos Factores') }}</x-primary-button>
            </div>
        </form>
    @else
        @if (session('status') == 'two-factor-authentication-enabled')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('La autenticación de dos factores ha sido habilitada.') }}
            </div>

            {{-- Show QR Code --}}
            <div class="mt-4">
                <p class="font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Escanea el siguiente código QR usando la aplicación de autenticación de tu teléfono.') }}
                </p>

                <div class="mt-4">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>
            </div>

            {{-- Confirmation Form --}}
            <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Confirmar configuración
                        </h3>
                        <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                            Para completar la configuración, ingresa el código de 6 dígitos de tu aplicación de autenticación.
                        </p>
                        
                        <form method="post" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="mt-3">
                            @csrf
                            <div class="flex items-center space-x-3">
                                <input type="text" 
                                       name="code" 
                                       placeholder="000000" 
                                       class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                                       inputmode="numeric"
                                       pattern="[0-9]*"
                                       maxlength="6"
                                       required>
                                <x-primary-button type="submit" class="bg-green-600 hover:bg-green-700">
                                    Confirmar
                                </x-primary-button>
                            </div>
                            @error('code')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>

            {{-- Important Notice --}}
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Configuración completada
                        </h3>
                        <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                            Tu autenticación de dos factores está activa. La próxima vez que inicies sesión, se te pedirá el código de 6 dígitos.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Show Recovery Codes --}}
            <div class="mt-4">
                <p class="font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Guarda estos códigos de recuperación en un lugar seguro. Pueden ser usados para recuperar el acceso a tu cuenta si tu dispositivo de autenticación de dos factores se pierde.') }}
                </p>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 rounded-lg">
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Disable 2FA --}}
        <form method="post" action="{{ url('/user/two-factor-authentication') }}" class="mt-6 space-y-6">
            @csrf
            @method('DELETE')

            <div>
                <x-danger-button onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Deshabilitar Autenticación de Dos Factores') }}
                </x-danger-button>
            </div>
        </form>

        {{-- Regenerate Recovery Codes --}}
        <form method="post" action="{{ url('/user/two-factor-recovery-codes') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-secondary-button onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Regenerar Códigos de Recuperación') }}
                </x-secondary-button>
            </div>
        </form>
    @endif
</section> 