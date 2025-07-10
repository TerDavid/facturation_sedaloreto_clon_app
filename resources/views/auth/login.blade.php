<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} - Login</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      background: url('https://elcomercio.pe/resizer/u2g2zJ881foh8jk6S1yEGaOWaGg=/980x0/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/6YIMOUU4G5G6PC7TKRBRFUHAFU.jpg') center/cover no-repeat;
    }
  </style>
</head>

<body class="font-sans text-gray-900 antialiased">
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black/50 bg-opacity-30">



    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md overflow-hidden sm:rounded-lg backdrop-blur-sm">
      <div class="place-self-center my-4" style="justify-self: center;">
        <a href="/">
          <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png"
            alt="Logo"
            class="w-auto h-16 sm:h-20">
        </a>
      </div>
      <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
          Iniciar Sesión
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          Ingresa tus credenciales para acceder al sistema
        </p>
      </div>

      <!-- Session Status -->
      <x-auth-session-status class="mb-4" :status="session('status')" />

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
          <x-input-label for="email" :value="__('Correo Electrónico')" />
          <x-text-input id="email"
            class="block mt-1 w-full"
            type="email"
            name="email"
            :value="old('email')"
            required
            autofocus
            autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
          <x-input-label for="password" :value="__('Contraseña')" />
          <x-text-input id="password"
            class="block mt-1 w-full"
            type="password"
            name="password"
            required
            autocomplete="current-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
          <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me"
              type="checkbox"
              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
              name="remember">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
              {{ __('Recordarme') }}
            </span>
          </label>
        </div>

        <div class="flex items-center justify-end mt-6">
          @if (Route::has('password.request'))
          <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            href="{{ route('password.request') }}">
            {{ __('¿Olvidaste tu contraseña?') }}
          </a>
          @endif

          <x-primary-button class="ml-3 bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900">
            {{ __('Iniciar Sesión') }}
          </x-primary-button>
        </div>
      </form>

      <!-- 2FA Info -->
      <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
          </svg>
          <p class="text-sm text-blue-800 dark:text-blue-200">
            Si tienes autenticación de dos factores activada, se te pedirá el código después del login.
          </p>
        </div>
      </div>
      <a href="/" class="mt-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center justify-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Regresar al inicio
      </a>
    </div>
  </div>
</body>

</html>