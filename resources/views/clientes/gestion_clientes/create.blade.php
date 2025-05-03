<x-app-layout>
    <x-slot name="header">
      <h2>Registrar cliente en {{ $ciudad->nombre }}</h2>
    </x-slot>

    <div class="p-6 max-w-md mx-auto">

      {{-- 1) Selector de sector --}}
      @unless(request('sector_id'))
        <form method="GET" action="{{ route('gestion_clientes.create', $ciudad) }}">
          @csrf
          <div class="mb-4">
            <label for="sector_id" class="block text-sm font-medium text-gray-700">
              Elige primero un sector
            </label>
            <select name="sector_id" id="sector_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
              <option value="">-- sector --</option>
              @foreach($sectores as $s)
                <option value="{{ $s->id }}">{{ $s->sector }}</option>
              @endforeach
            </select>
          </div>
          <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Continuar
          </button>
        </form>
      @else
        {{-- 2) Formulario completo --}}
        <form method="POST" action="{{ route('gestion_clientes.store', $ciudad) }}">
          @csrf

          {{-- campos ocultos básicos --}}
          <input type="hidden" name="ciudad_id"  value="{{ $ciudad->id }}">
          <input type="hidden" name="sector_id"  value="{{ request('sector_id') }}">
          <input type="hidden" name="estado"     value="1">

          {{-- Código de suministro --}}
          <div class="mb-4">
            <label for="codigo_suministro" class="block text-sm font-medium text-gray-700">
              Código de suministro
            </label>
            <input id="codigo_suministro"
                   name="codigo_suministro"
                   type="text"
                   value="{{ old('codigo_suministro') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            @error('codigo_suministro')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Datos básicos --}}
          @foreach(['nombre','apellido','dni','celular','correo','direccion'] as $f)
            <div class="mb-4">
              <label for="{{ $f }}" class="block text-sm font-medium text-gray-700">
                {{ ucfirst($f) }}
              </label>
              <input id="{{ $f }}" name="{{ $f }}"
                     type="{{ $f === 'correo' ? 'email' : 'text' }}"
                     value="{{ old($f) }}"
                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
              @error($f)
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          @endforeach

          {{-- Manzana --}}
          <div class="mb-4">
            <label for="manzana_id" class="block text-sm font-medium text-gray-700">
              Manzana
            </label>
            <select id="manzana_id" name="manzana_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
              <option value="">-- selecciona manzana --</option>
              @foreach($manzanas as $m)
                <option value="{{ $m->id }}"
                  {{ old('manzana_id') == $m->id ? 'selected' : '' }}>
                  {{ $m->manzana }}
                </option>
              @endforeach
            </select>
            @error('manzana_id')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Medidor --}}
          <div class="mb-4">
            <label for="medidor_id" class="block text-sm font-medium text-gray-700">
              Medidor
            </label>
            <select id="medidor_id" name="medidor_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
              <option value="">-- selecciona medidor --</option>
              @foreach($medidores as $m)
                <option value="{{ $m->id }}"
                  {{ old('medidor_id') == $m->id ? 'selected' : '' }}>
                  {{ $m->codigo_medidor }}
                  ({{ ['Inactivo','Activo','En revisión'][$m->estado_medidor] }})
                </option>
              @endforeach
            </select>
            @error('medidor_id')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

         {{-- Tarifa --}}
<div class="mb-4">
    <label for="tarifa_id" class="block text-sm font-medium text-gray-700">
      Tarifa aplicable
    </label>
    <select id="tarifa_id"
            name="tarifa_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            @if($medidores->isEmpty()) disabled @endif>
      <option value="">-- selecciona tarifa --</option>
      @foreach($tarifas as $t)
        <option value="{{ $t->id }}"
          {{ old('tarifa_id') == $t->id ? 'selected' : '' }}>
          {{ $t->categoria }}
          — {{ $t->rango_min }}–{{ is_null($t->rango_max)?'∞':$t->rango_max }} m³:
          agua S/{{ $t->tarifa_agua }}, alcantarillado S/{{ $t->tarifa_alcantarillado }}
          — cargo fijo S/{{ $t->cargo_fijo }}
        </option>
      @endforeach
    </select>
    @error('tarifa_id')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

          {{-- Consumo sin medidor --}}
          <div class="mb-6">
            <label for="consumo_sin_medidor_id" class="block text-sm font-medium text-gray-700">
              Consumo sin medidor
            </label>
            <select id="consumo_sin_medidor_id" name="consumo_sin_medidor_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
              <option value="">-- selecciona opción --</option>
              @foreach(\App\Models\ConsumoSinMedidor::all() as $c)
                <option value="{{ $c->id }}"
                  {{ old('consumo_sin_medidor_id') == $c->id ? 'selected' : '' }}>
                  {{ $c->categoria }} — {{ $c->descripcion }}
                </option>
              @endforeach
            </select>
            @error('consumo_sin_medidor_id')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex space-x-4">
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded">
              Guardar cliente
            </button>
            <a href="{{ route('gestion_clientes.index', $ciudad) }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
              Cancelar
            </a>
          </div>
        </form>
      @endunless

    </div>
</x-app-layout>
