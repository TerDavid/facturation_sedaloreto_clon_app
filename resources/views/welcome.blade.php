<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consulta de Suministro</title>

  <!-- Fonts & Vite -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <style>
    body {
      background: url('https://elcomercio.pe/resizer/0wMuRPeoVuNVDhvba8wDO1Y5NiY=/980x0/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/5SN2I6LI5ZCNJDQADXNVFXCHBU.jpg') center/cover no-repeat;
    }
  </style>
</head>
<body class="relative min-h-screen flex flex-col items-center justify-center bg-black bg-opacity-50 p-4">

  {{-- overlay --}}
  <div class="absolute inset-0 bg-black opacity-60"></div>

  {{-- AppBar --}}
  <header class="absolute top-0 left-0 w-full z-20 flex flex-col sm:flex-row items-center justify-between px-4 py-3 space-y-2 sm:space-y-0">
    <img
      src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png"
      alt="Logo"
      class="h-12 w-auto"
    />
    <div class="text-white font-bold text-xs sm:text-sm flex flex-col sm:flex-row sm:space-x-6 space-y-1 sm:space-y-0 text-center sm:text-left">
      <span>WhatsApp: 965962357</span>
      <span>Correo: atencionalcliente@sedaloreto.com.pe</span>
    </div>
  </header>

  {{-- Title --}}
  <h1 class="relative z-10 text-white font-bold text-2xl sm:text-3xl mb-6 text-center px-4">
    Consulta de Suministro
  </h1>

  {{-- Form Card --}}
  <main
    class="relative z-10 w-full max-w-sm sm:max-w-md bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90 rounded-lg shadow-lg"
    style="padding: 5vh 5vw;"
  >
    <form>
      @csrf

      <div class="mb-4">
        <label for="codigo" class="block text-gray-700 dark:text-gray-200 font-bold mb-1">
          Código de suministro
        </label>
        <input
          id="codigo"
          name="codigo"
          type="text"
          required
          class="w-full px-3 py-2 border rounded-md font-bold focus:outline-none focus:ring-2 focus:ring-red-500"
          placeholder="Ingrese su código"
        />
      </div>

      <div class="mb-6">
        <label for="ciudad" class="block text-gray-700 dark:text-gray-200 font-bold mb-1">
          Ciudad
        </label>
        <select
          id="ciudad"
          name="ciudad"
          required
          class="w-full px-3 py-2 border rounded-md font-bold focus:outline-none focus:ring-2 focus:ring-red-500"
        >
          <option value="" disabled selected>Seleccione una opción</option>
          <option value="iquitos">Iquitos</option>
          <option value="contamana">Contamana</option>
          <option value="yurimaguas">Yurimaguas</option>
        </select>
      </div>

      <button
        type="submit"
        class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md transition"
      >
        Consultar
      </button>
    </form>
  </main>

</body>
</html>
