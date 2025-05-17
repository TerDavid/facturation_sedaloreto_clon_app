<x-app-layout>
    <x-slot name="header">
      <h2 class="font-bold text-4xl text-black leading-tight">
        {{ __("Editar Consumo #{$consumo->id}") }}
      </h2>
    </x-slot>

    <div class="mt-8 p-6 space-y-4">
      @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('facturation.consumo.update', $consumo) }}"
            method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Cliente --}}
        <div>
          <label for="cliente_id" class="block font-medium">Cliente</label>
          <select name="cliente_id" id="cliente_id"
                  class="mt-1 block w-full border-gray-300 rounded">
            @foreach($clientes as $cli)
              <option value="{{ $cli->id }}"
                {{ old('cliente_id', $consumo->cliente_id) == $cli->id ? 'selected' : '' }}>
                {{ $cli->code_suministro }} – {{ $cli->nombre }} {{ $cli->apellido }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- m³ Consumidos --}}
        <div>
          <label for="m3_consumidos" class="block font-medium">m³ Consumidos</label>
          <input type="number" name="m3_consumidos" id="m3_consumidos"
                 class="mt-1 block w-full border-gray-300 rounded"
                 value="{{ old('m3_consumidos', $consumo->m3_consumidos) }}">
        </div>

        {{-- Fecha y Hora de Registro --}}
        <div>
          <label for="hora_registro_consumo" class="block font-medium">Fecha y Hora de Registro</label>
          <input type="datetime-local" name="hora_registro_consumo"
                 id="hora_registro_consumo"
                 class="mt-1 block w-full border-gray-300 rounded"
                 value="{{ old('hora_registro_consumo',
                     $consumo->hora_registro_consumo
                       ? \Carbon\Carbon::parse($consumo->hora_registro_consumo)
                                      ->format('Y-m-d\TH:i')
                       : ''
                 ) }}">
        </div>

        {{-- Fecha de Emisión --}}
        <div>
          <label for="fecha_emision" class="block font-medium">Fecha de Emisión</label>
          <input type="date" name="fecha_emision" id="fecha_emision"
                 class="mt-1 block w-full border-gray-300 rounded"
                 value="{{ old('fecha_emision', $consumo->fecha_emision) }}">
        </div>

        {{-- Fecha de Vencimiento --}}
        <div>
          <label for="fecha_vencimiento" class="block font-medium">Fecha de Vencimiento</label>
          <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                 class="mt-1 block w-full border-gray-300 rounded"
                 value="{{ old('fecha_vencimiento', $consumo->fecha_vencimiento) }}">
        </div>

        {{-- Valor --}}
        <div>
          <label for="valor" class="block font-medium">Valor S/.</label>
          <input type="text" name="valor" id="valor"
                 class="mt-1 block w-full border-gray-300 rounded"
                 value="{{ old('valor', $consumo->valor) }}">
        </div>

        <div class="flex items-center space-x-4">
          <button type="submit"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
            {{ __('Actualizar') }}
          </button>
          <a href="{{ route('facturation.consumo.index') }}"
             class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
            {{ __('Cancelar') }}
          </a>
        </div>
      </form>
    </div>
</x-app-layout>
