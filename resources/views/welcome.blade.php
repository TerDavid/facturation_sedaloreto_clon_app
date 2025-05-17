{{-- resources/views/consulta.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Consulta de Suministro</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    body {
      background: url('https://elcomercio.pe/resizer/u2g2zJ881foh8jk6S1yEGaOWaGg=/980x0/smart/filters:format(jpeg):quality(75)/cloudfront-us-east-1.images.arcpublishing.com/elcomercio/6YIMOUU4G5G6PC7TKRBRFUHAFU.jpg')
        center/cover no-repeat;
    }
  </style>
</head>
<body
  class="relative min-h-screen flex flex-col items-center justify-start bg-black bg-opacity-50 p-4"
>
  <div class="absolute inset-0 bg-black opacity-60"></div>

  {{-- AppBar --}}
  <header class="absolute top-0 left-0 w-full z-20 flex flex-col md:flex-row items-center justify-between px-4 py-3">
    <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png"
         alt="Logo" class="h-16 md:h-20 w-auto" />
    <div class="flex flex-col md:flex-row items-center md:space-x-6 mt-2 md:mt-0">
      <div class="flex flex-col md:flex-row items-center text-white font-bold text-xs md:text-sm space-y-1 md:space-y-0 md:space-x-6">
        <span>WhatsApp: 965962357</span>
        <span>Correo: atencionalcliente@sedaloreto.com.pe</span>
      </div>
      <a href="{{ route('login') }}"
         class="ml-0 md:ml-4 mt-2 md:mt-0 text-white font-bold bg-red-600 hover:bg-red-700 px-4 py-1 rounded-md text-sm transition">
        Entrar
      </a>
    </div>
  </header>

  {{-- Contenedor principal --}}
  <div class="relative z-10 pt-24 w-full max-w-6xl mx-auto flex flex-col md:flex-row items-start justify-center gap-8">

    {{-- Formulario --}}
    <main class="w-full md:w-1/2 bg-white bg-opacity-90 rounded-lg shadow-lg p-8">
      <h1 class="uppercase text-black font-bold text-2xl md:text-4xl mb-6 text-center">
        Consulta consumo mes {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM') }}
      </h1>

      @if(session('error'))
        <div class="mb-4 text-red-600 font-bold text-center">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('consulta-factura.consultar') }}" method="POST" class="w-full space-y-4">
        @csrf

        <div>
          <label for="codigo" class="block font-bold mb-1">Código de suministro</label>
          <input id="codigo"
                 name="codigo"
                 type="text"
                 value="{{ old('codigo') }}"
                 required
                 placeholder="Ingrese su código"
                 class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 @error('codigo') border-red-500 @enderror">
          @error('codigo')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="ciudad" class="block font-bold mb-1">Ciudad</label>
          <select id="ciudad"
                  name="ciudad"
                  required
                  class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 @error('ciudad') border-red-500 @enderror">
            <option value="" disabled {{ !old('ciudad') ? 'selected' : '' }}>
              Seleccione una ciudad
            </option>
            @foreach($ciudades as $c)
              <option value="{{ $c->id }}"
                {{ old('ciudad') == $c->id ? 'selected' : '' }}>
                {{ $c->nombre }}
              </option>
            @endforeach
          </select>
          @error('ciudad')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit"
                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md transition">
          Consultar
        </button>
      </form>
    </main>

    {{-- Resultado --}}
    @isset($consumo)
      <section
        x-data="{ show: true }"
        x-show="show"
        class="w-full md:w-1/2 bg-white bg-opacity-90 rounded-lg shadow-lg p-6 relative"
      >
        {{-- Botón cerrar --}}
        <button
          @click="show = false"
          class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold"
          aria-label="Cerrar"
        >×</button>

        <h2 class="text-xl font-bold mb-4">
          Consumo {{ \Carbon\Carbon::parse($consumo->fecha_emision)->locale('es')->isoFormat('MMMM YYYY') }}
        </h2>
        <ul class="space-y-2 text-gray-800 mb-4">
          <li><strong>Consumo (m³):</strong> {{ $consumo->m3_consumidos ?? '–' }}</li>
          <li><strong>Emisión:</strong> {{ $consumo->fecha_emision
              ? \Carbon\Carbon::parse($consumo->fecha_emision)->format('d/m/Y')
              : '–' }}</li>
          <li><strong>Vencimiento:</strong> {{ $consumo->fecha_vencimiento
              ? \Carbon\Carbon::parse($consumo->fecha_vencimiento)->format('d/m/Y')
              : '–' }}</li>
          <li><strong>Valor a pagar:</strong> S/ {{ number_format($consumo->valor, 2) }}</li>
          <li><strong>Código suministro:</strong> {{ $consumo->cliente->code_suministro }}</li>
          <li><strong>Ciudad cliente:</strong> {{ $consumo->cliente->manzana->ciudad->nombre }}</li>
        </ul>

        {{-- Botón Descargar PDF --}}
        <a href="{{ route('consulta-factura.descargar', ['codigo' => $consumo->cliente->code_suministro]) }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold">
          Descargar PDF
        </a>
      </section>
    @endisset

  </div>

</body>
</html>
