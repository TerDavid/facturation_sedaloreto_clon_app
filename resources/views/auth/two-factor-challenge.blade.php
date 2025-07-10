<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Verificación 2FA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png" 
                     alt="Logo" 
                     class="w-auto h-16 sm:h-20">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Verificación de Dos Factores
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Completa la verificación para acceder a tu cuenta
                </p>
            </div>

            <div x-data="{ recovery: false }">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <div x-show="! recovery">
                        Ingresa el código de 6 dígitos de tu aplicación de autenticación.
                    </div>

                    <!-- <div x-show="recovery">
                        Ingresa uno de tus códigos de recuperación de emergencia.
                    </div> -->
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                    Error de verificación
                                </h3>
                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <div x-show="! recovery">
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Código de Autenticación
                        </label>
                        <x-input-text id="code" 
                               class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                               type="text" 
                               inputmode="numeric" 
                               name="code" 
                               autofocus 
                               x-ref="code" 
                               autocomplete="one-time-code" 
                               placeholder="000000" />
                    </div>

                    <!-- <div x-show="recovery">
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Código de Recuperación
                        </label>
                        <input id="recovery_code" 
                               class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                               type="text" 
                               name="recovery_code" 
                               x-ref="recovery_code" 
                               autocomplete="one-time-code" 
                               placeholder="Código de recuperación" />
                    </div> -->

                    <div class="flex items-center justify-between mt-6">
                        <!-- <button type="button" 
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 underline cursor-pointer"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                            Usar código de recuperación
                        </button>

                        <button type="button" 
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 underline cursor-pointer"
                                x-show="recovery"
                                x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                            Usar código de autenticación
                        </button> -->

                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Verificar
                        </button>
                    </div>
                </form>

                <!-- Help Info -->
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <p class="font-medium mb-1">¿Necesitas ayuda?</p>
                            <p>Si perdiste tu dispositivo de autenticación, usa un código de recuperación o contacta al administrador.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 