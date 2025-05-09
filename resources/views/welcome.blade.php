<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Consulta de Suministro</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    body {
      background: url('https://elcomercio.pe/resizer/u2g2zJ881foh8jk6S1yEGaOWaGg=/980x0/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/6YIMOUU4G5G6PC7TKRBRFUHAFU.jpg') center/cover no-repeat;
    }
  </style>
</head>
<body class="relative min-h-screen flex items-center justify-center bg-black bg-opacity-50 p-4">
  <div class="absolute inset-0 bg-black opacity-60"></div>

  {{-- AppBar --}}
  <header class="absolute top-0 left-0 w-full z-20 flex flex-col sm:flex-row items-center justify-between px-4 py-3 space-y-2 sm:space-y-0">
    <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png" alt="Logo" class="sm:h-20 w-auto" />
    <div class="flex flex-col sm:flex-row items-center sm:space-x-6 space-y-2 sm:space-y-0">
      <div class="flex flex-col sm:flex-row items-center text-white font-bold text-xs sm:text-sm space-y-1 sm:space-y-0 sm:space-x-6 text-center sm:text-left">
        <span>WhatsApp: 965962357</span>
        <span>Correo: atencionalcliente@sedaloreto.com.pe</span>
      </div>
      <a href="{{ route('login') }}" class="text-white font-bold bg-red-600 hover:bg-red-700 px-4 py-1 rounded-md transition text-sm">
        Entrar
      </a>
    </div>
  </header>

  {{-- Title --}}
  <h1 class="relative z-10 text-white font-bold text-2xl sm:text-4xl mb-6 text-center px-4">
    Consulta factura mes {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM') }}
  </h1>

  {{-- Form Card --}}
  <main class="relative z-10 w-full max-w-sm sm:max-w-md bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90 rounded-lg shadow-lg p-8">
    @if(session('error'))
      <div class="mb-4 text-red-600 font-bold text-center">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('consulta-factura.consultar') }}" method="POST">
      @csrf

      {{-- Código de suministro --}}
      <div class="mb-4">
        <label for="codigo" class="block font-bold mb-1 text-gray-700">Código de suministro</label>
        <input
          id="codigo" name="codigo" type="text"
          value="{{ old('codigo') }}"
          required
          class="w-full px-3 py-2 border rounded-md font-bold focus:ring-2 focus:ring-red-500 @error('codigo') border-red-500 @enderror"
          placeholder="Ingrese su código"
        />
        @error('codigo')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Ciudad --}}
      <div class="mb-6">
        <label for="ciudad" class="block font-bold mb-1 text-gray-700">Ciudad</label>
        <select
          id="ciudad" name="ciudad" required
          class="w-full px-3 py-2 border rounded-md font-bold focus:ring-2 focus:ring-red-500 @error('ciudad') border-red-500 @enderror"
        >
          <option value="" disabled {{ !old('ciudad') && !isset($factura) ? 'selected' : '' }}>
            Seleccione una ciudad
          </option>
          @foreach($ciudades as $c)
            <option
              value="{{ $c->id }}"
              {{ old('ciudad') == $c->id || (isset($factura) && $factura->cliente->ciudad_id == $c->id) ? 'selected' : '' }}
            >
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
        @error('ciudad')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button
        type="submit"
        class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md transition"
      >
        Consultar
      </button>
    </form>
  </main>

  {{-- Resultado --}}
  @isset($factura)
    <section class="relative z-10 mt-8 w-full max-w-md bg-white bg-opacity-90 rounded-lg shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">
        Factura de {{ \Carbon\Carbon::parse($factura->fecha_emision)->locale('es')->isoFormat('MMMM YYYY') }}
      </h2>
      <ul class="space-y-2 text-gray-800">
        <li><strong>Recibo:</strong> {{ $factura->numero_recibo }}</li>
        <li><strong>Emisión:</strong> {{ $factura->fecha_emision->format('d/m/Y') }}</li>
        <li><strong>Vencimiento:</strong> {{ $factura->fecha_vencimiento->format('d/m/Y') }}</li>
        <li><strong>Valor a pagar:</strong> S/ {{ number_format($factura->valor_pago,2) }}</li>
        <li><strong>Código suministro:</strong> {{ $factura->cliente->codigo_suministro }}</li>
        <li><strong>Ciudad cliente:</strong> {{ $factura->cliente->ciudad->nombre }}</li>
      </ul>
    </section>
  @endisset
</body>
</html>
