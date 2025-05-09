{{-- resources/views/clientes/gestion_clientes/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Editar cliente: {{ $cliente->nombre }} {{ $cliente->apellido }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-gray-900 rounded-lg shadow">
      {{-- 1) Cambio de sector --}}
      <form method="GET"
            action="{{ route('gestion_clientes.edit', [$ciudad, $cliente]) }}"
            class="mb-6 flex items-end space-x-4">
        @csrf
        <div class="w-1/3">
          <label for="sector_id" class="block text-sm font-medium text-gray-300">
            Sector
          </label>
          <select id="sector_id" name="sector_id"
                  onchange="this.form.submit()"
                  class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
            <option value="">-- selecciona sector --</option>
            @foreach($sectores as $s)
              <option value="{{ $s->id }}"
                {{ $sector_id == $s->id ? 'selected':'' }}>
                {{ $s->sector }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          Cambiar
        </button>
      </form>

      {{-- 2) Formulario principal --}}
      <form method="POST"
            action="{{ route('gestion_clientes.update', [$ciudad, $cliente]) }}">
        @csrf @method('PUT')

        {{-- ocultos --}}
        <input type="hidden" name="ciudad_id"  value="{{ $ciudad->id }}" />
        <input type="hidden" name="sector_id"  value="{{ $sector_id }}" />

        <div class="grid grid-cols-2 gap-6">
          {{-- Estado --}}
          <div>
            <label for="estado" class="block text-sm font-medium text-gray-300">
              Estado
            </label>
            <select id="estado" name="estado"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
              <option value="1" {{ old('estado', $cliente->estado)==='1' ? 'selected':'' }}>Sin deuda</option>
              <option value="0" {{ old('estado', $cliente->estado)==='0' ? 'selected':'' }}>Inactivo</option>
              <option value="2" {{ old('estado', $cliente->estado)==='2' ? 'selected':'' }}>Deuda</option>
              <option value="3" {{ old('estado', $cliente->estado)==='3' ? 'selected':'' }}>Corte</option>
            </select>
          </div>

          {{-- Código de suministro --}}
          <div>
            <label for="codigo_suministro" class="block text-sm font-medium text-gray-300">
              Código de suministro
            </label>
            <input id="codigo_suministro"
                   name="codigo_suministro"
                   type="text"
                   value="{{ old('codigo_suministro', $cliente->codigo_suministro) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Nombre --}}
          <div>
            <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre</label>
            <input id="nombre"
                   name="nombre"
                   type="text"
                   value="{{ old('nombre', $cliente->nombre) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Apellido --}}
          <div>
            <label for="apellido" class="block text-sm font-medium text-gray-300">Apellido</label>
            <input id="apellido"
                   name="apellido"
                   type="text"
                   value="{{ old('apellido', $cliente->apellido) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- DNI --}}
          <div>
            <label for="dni" class="block text-sm font-medium text-gray-300">DNI</label>
            <input id="dni"
                   name="dni"
                   type="text"
                   value="{{ old('dni', $cliente->dni) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Celular --}}
          <div>
            <label for="celular" class="block text-sm font-medium text-gray-300">Celular</label>
            <input id="celular"
                   name="celular"
                   type="text"
                   value="{{ old('celular', $cliente->celular) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Correo --}}
          <div>
            <label for="correo" class="block text-sm font-medium text-gray-300">Correo</label>
            <input id="correo"
                   name="correo"
                   type="email"
                   value="{{ old('correo', $cliente->correo) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Dirección --}}
          <div class="col-span-2">
            <label for="direccion" class="block text-sm font-medium text-gray-300">Dirección</label>
            <input id="direccion"
                   name="direccion"
                   type="text"
                   value="{{ old('direccion', $cliente->direccion) }}"
                   class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
          </div>

          {{-- Manzana --}}
          <div>
            <label for="manzana_id" class="block text-sm font-medium text-gray-300">Manzana</label>
            <select id="manzana_id"
                    name="manzana_id"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
              <option value="">-- selecciona manzana --</option>
              @foreach($manzanas as $m)
                <option value="{{ $m->id }}"
                  {{ old('manzana_id', $cliente->manzana_id)==$m->id ? 'selected':'' }}>
                  {{ $m->manzana }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Medidor --}}
          <div>
            <label for="medidor_id" class="block text-sm font-medium text-gray-300">Medidor</label>
            <select id="medidor_id"
                    name="medidor_id"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
              <option value="">-- selecciona medidor --</option>
              @foreach($medidores as $m)
                <option value="{{ $m->id }}"
                  {{ old('medidor_id', $cliente->medidor_id)==$m->id ? 'selected':'' }}>
                  {{ $m->codigo_medidor }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Tarifa --}}
          <div>
            <label for="tarifa_id" class="block text-sm font-medium text-gray-300">Tarifa aplicable</label>
            <select id="tarifa_id"
                    name="tarifa_id"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"
                    @if(!$cliente->medidor_id) disabled @endif>
              <option value="">-- selecciona tarifa --</option>
              @foreach($tarifas as $t)
                <option value="{{ $t->id }}"
                  {{ old('tarifa_id', $cliente->tarifa_id)==$t->id ? 'selected':'' }}>
                  {{ $t->categoria }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Consumo sin medidor --}}
          <div>
            <label for="consumo_sin_medidor_id" class="block text-sm font-medium text-gray-300">
              Consumo sin medidor
            </label>
            <select id="consumo_sin_medidor_id"
                    name="consumo_sin_medidor_id"
                    class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
              <option value="">-- selecciona opción --</option>
              @foreach($consumosSM as $c)
                <option value="{{ $c->id }}"
                  {{ old('consumo_sin_medidor_id', $cliente->consumo_sin_medidor_id)==$c->id ? 'selected':'' }}>
                  {{ $c->categoria }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- botones --}}
        <div class="mt-8 flex justify-end space-x-4">
          <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Actualizar cliente
          </button>
          <a href="{{ route('gestion_clientes.index', $ciudad) }}"
             class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </x-app-layout>
