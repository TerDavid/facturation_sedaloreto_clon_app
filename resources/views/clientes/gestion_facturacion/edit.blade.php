{{-- resources/views/clientes/gestion_facturacion/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Editar factura · {{ $factura->numero_recibo }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-gray-900 rounded-lg shadow">
      <form method="POST"
            action="{{ route('facturacion.update', $factura) }}">
        @csrf @method('PUT')

        {{-- Cliente inmutable --}}
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-300">Cliente</label>
          <p class="mt-1 text-white">{{ $factura->cliente->nombre }} {{ $factura->cliente->apellido }} ({{ $factura->cliente->dni }})</p>
        </div>

        {{-- Fechas --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label for="fecha_emision" class="block text-sm font-medium text-gray-300">Emisión</label>
            <input id="fecha_emision" name="fecha_emision" type="date"
                   value="{{ old('fecha_emision', $factura->fecha_emision->toDateString()) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('fecha_emision')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-300">Vencimiento</label>
            <input id="fecha_vencimiento" name="fecha_vencimiento" type="date"
                   value="{{ old('fecha_vencimiento', $factura->fecha_vencimiento->toDateString()) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('fecha_vencimiento')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- Nº Recibo y Mes --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label for="numero_recibo" class="block text-sm font-medium text-gray-300">Nº Recibo</label>
            <input id="numero_recibo" name="numero_recibo" type="text"
                   value="{{ old('numero_recibo', $factura->numero_recibo) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('numero_recibo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label for="mes_factura" class="block text-sm font-medium text-gray-300">Mes factura</label>
            <input id="mes_factura" name="mes_factura" type="text"
                   value="{{ old('mes_factura', $factura->mes_factura) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('mes_factura')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>
        </div>

        {{-- Valor pago --}}
        <div class="mb-6">
          <label for="valor_pago" class="block text-sm font-medium text-gray-300">Valor pago</label>
          <input id="valor_pago" name="valor_pago" type="number" step="0.01"
                 value="{{ old('valor_pago', $factura->valor_pago) }}"
                 class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
          @error('valor_pago')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-4">
          <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Actualizar
          </button>
          <a href="{{ route('facturacion.clientes', [$factura->sector->reservorio->bomba->ciudad, $factura->sector]) }}"
             class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </x-app-layout>
