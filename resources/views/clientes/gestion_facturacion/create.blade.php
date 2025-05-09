{{-- resources/views/clientes/gestion_facturacion/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Emitir facturas · Sector {{ $sector->sector }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-gray-900 rounded-lg shadow">
      <form method="POST"
            action="{{ route('facturacion.store', [$ciudad = $sector->reservorio->bomba->ciudad, $sector]) }}">
        @csrf

        {{-- 1) Selección múltiple de clientes con “Seleccionar todos” --}}
        <div class="mb-6">
          <div class="flex items-center mb-2">
            <input id="select_all" type="checkbox"
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"/>
            <label for="select_all" class="ml-2 block text-sm font-medium text-gray-300">
              Seleccionar todos
            </label>
          </div>
          <label class="block text-sm font-medium text-gray-300 mb-1">Clientes a facturar</label>
          <select name="cliente_ids[]" multiple
                  id="clientes_select"
                  class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded h-48">
            @foreach($clientes as $c)
              <option value="{{ $c->id }}">
                {{ $c->nombre }} {{ $c->apellido }} — {{ $c->dni }}
              </option>
            @endforeach
          </select>
          @error('cliente_ids')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- 2) Fechas y metadatos comunes --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div>
            <label for="fecha_emision" class="block text-sm font-medium text-gray-300">Emisión</label>
            <input id="fecha_emision" name="fecha_emision" type="date"
                   value="{{ old('fecha_emision') }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('fecha_emision')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-300">Vencimiento</label>
            <input id="fecha_vencimiento" name="fecha_vencimiento" type="date"
                   value="{{ old('fecha_vencimiento') }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
            @error('fecha_vencimiento')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- 3) Mes de factura --}}
        <div class="mb-6">
          <label for="mes_factura" class="block text-sm font-medium text-gray-300">Mes factura</label>
          <input id="mes_factura" name="mes_factura" type="month"
                 value="{{ old('mes_factura') }}"
                 class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"/>
          @error('mes_factura')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- 4) Botones --}}
        <div class="flex justify-end space-x-4">
          <button type="submit"
                  class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
            Emitir facturas
          </button>
          <a href="{{ route('facturacion.clientes', [$ciudad, $sector]) }}"
             class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Cancelar
          </a>
        </div>
      </form>
    </div>

    {{-- Script para “Seleccionar todos” --}}
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select_all');
        const selectBox        = document.getElementById('clientes_select');
        selectAllCheckbox.addEventListener('change', function() {
          for (let i = 0; i < selectBox.options.length; i++) {
            selectBox.options[i].selected = this.checked;
          }
        });
      });
    </script>
</x-app-layout>
