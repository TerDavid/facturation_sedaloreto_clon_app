<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Fonts & Vite -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css','resources/js/app.js'])
  @endif

  <style>
    body {
      background: url('https://elcomercio.pe/resizer/0wMuRPeoVuNVDhvba8wDO1Y5NiY=/980x0/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/5SN2I6LI5ZCNJDQADXNVFXCHBU.jpg')
                  center/cover no-repeat;
    }
  </style>
</head>
<body class="relative min-h-screen flex flex-col items-center justify-center bg-black bg-opacity-50 p-4">

  {{-- dark overlay --}}
  <div class="absolute inset-0 bg-black opacity-60"></div>

  {{-- AppBar --}}
  <header
    class="absolute top-0 left-0 w-full z-20
           flex flex-col sm:flex-row items-center
           justify-between px-4 py-3
           space-y-2 sm:space-y-0"
  >
    <img
      src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png"
      alt="Logo"
      class="sm:h-20 w-auto"
    />


  </header>

  {{-- Title --}}
  <h1 class="relative z-10 text-white font-bold text-2xl sm:text-4xl mb-6 text-center px-4">
    Inicio de sesión
  </h1>


  {{-- Login Card --}}
  <main
    class="relative z-10 w-full max-w-sm sm:max-w-md
           bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90
           rounded-lg shadow-lg"
    style="padding: 5vh 5vw;"
  >
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Email Address -->
      <div class="mb-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input
          id="email"
          class="block mt-1 w-full"
          type="email"
          name="email"
          :value="old('email')"
          required
          autofocus
          autocomplete="username"
        />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4 mb-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input
          id="password"
          class="block mt-1 w-full"
          type="password"
          name="password"
          required
          autocomplete="current-password"
        />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Remember Me -->
      <div class="block mb-4">
        <label for="remember_me" class="inline-flex items-center">
          <input
            id="remember_me"
            type="checkbox"
            class="rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700
                   text-indigo-600 shadow-sm focus:ring-indigo-500
                   dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
            name="remember"
          />
          <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Remember me') }}
          </span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        {{-- @if (Route::has('password.request'))
          <a
            class="underline text-sm text-gray-600 dark:text-gray-400
                   hover:text-gray-900 dark:hover:text-gray-100
                   rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2
                   focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            href="{{ route('password.request') }}"
          >
            {{ __('Forgot your password?') }}
          </a>
        @endif --}}

        <button
  type="submit"
  class="text-white font-bold bg-red-600 hover:bg-red-700
         px-4 py-1 rounded-md transition text-sm ms-3"
>
  {{ __('Log in') }}
</button>

      </div>
    </form>
  </main>

</body>
</html>
