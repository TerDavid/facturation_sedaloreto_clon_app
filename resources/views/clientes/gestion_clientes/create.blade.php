{{-- resources/views/clientes/gestion_clientes/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold text-white">
        Registrar cliente en {{ $ciudad->nombre }}
      </h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-gray-900 rounded-lg shadow">
      {{-- 1) Selector de sector --}}
      <form method="GET"
            action="{{ route('gestion_clientes.create', $ciudad) }}"
            class="mb-6 flex items-end space-x-4">
        @csrf
        <div class="w-1/3">
          <label for="sector_id" class="block text-sm font-medium text-gray-300">
            Elige primero un sector
          </label>
          <select id="sector_id"
                  name="sector_id"
                  onchange="this.form.submit()"
                  class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded">
            <option value="">-- selecciona sector --</option>
            @foreach($sectores as $s)
              <option value="{{ $s->id }}"
                {{ (request('sector_id') == $s->id) ? 'selected':'' }}>
                {{ $s->sector }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          Continuar
        </button>
      </form>

      @if(request('sector_id'))
        {{-- 2) Formulario completo --}}
        <form method="POST"
              action="{{ route('gestion_clientes.store', $ciudad) }}">
          @csrf

          {{-- ocultos básicos --}}
          <input type="hidden" name="ciudad_id" value="{{ $ciudad->id }}">
          <input type="hidden" name="sector_id" value="{{ request('sector_id') }}">
          <input type="hidden" name="estado"     value="1">

          <div class="grid grid-cols-2 gap-6">
            {{-- Código de suministro --}}
            <div>
              <label for="codigo_suministro" class="block text-sm font-medium text-gray-300">
                Código de suministro
              </label>
              <input id="codigo_suministro"
                     name="codigo_suministro"
                     type="text"
                     value="{{ old('codigo_suministro') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('codigo_suministro')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Nombre --}}
            <div>
              <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre</label>
              <input id="nombre"
                     name="nombre"
                     type="text"
                     value="{{ old('nombre') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Apellido --}}
            <div>
              <label for="apellido" class="block text-sm font-medium text-gray-300">Apellido</label>
              <input id="apellido"
                     name="apellido"
                     type="text"
                     value="{{ old('apellido') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('apellido')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- DNI --}}
            <div>
              <label for="dni" class="block text-sm font-medium text-gray-300">DNI</label>
              <input id="dni"
                     name="dni"
                     type="text"
                     value="{{ old('dni') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('dni')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Celular --}}
            <div>
              <label for="celular" class="block text-sm font-medium text-gray-300">Celular</label>
              <input id="celular"
                     name="celular"
                     type="text"
                     value="{{ old('celular') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('celular')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Correo --}}
            <div>
              <label for="correo" class="block text-sm font-medium text-gray-300">Correo</label>
              <input id="correo"
                     name="correo"
                     type="email"
                     value="{{ old('correo') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('correo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Dirección --}}
            <div class="col-span-2">
              <label for="direccion" class="block text-sm font-medium text-gray-300">Dirección</label>
              <input id="direccion"
                     name="direccion"
                     type="text"
                     value="{{ old('direccion') }}"
                     class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded" />
              @error('direccion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
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
                    {{ old('manzana_id') == $m->id ? 'selected':'' }}>
                    {{ $m->manzana }}
                  </option>
                @endforeach
              </select>
              @error('manzana_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
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
                    {{ old('medidor_id') == $m->id ? 'selected':'' }}>
                    {{ $m->codigo_medidor }}
                  </option>
                @endforeach
              </select>
              @error('medidor_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Tarifa --}}
            <div>
              <label for="tarifa_id" class="block text-sm font-medium text-gray-300">Tarifa aplicable</label>
              <select id="tarifa_id"
                      name="tarifa_id"
                      class="mt-1 block w-full bg-gray-800 text-white border-gray-700 rounded"
                      @if(!old('medidor_id')) disabled @endif>
                <option value="">-- selecciona tarifa --</option>
                @foreach($tarifas as $t)
                  <option value="{{ $t->id }}"
                    {{ old('tarifa_id') == $t->id ? 'selected':'' }}>
                    {{ $t->categoria }}
                  </option>
                @endforeach
              </select>
              @error('tarifa_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
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
                @foreach(\App\Models\ConsumoSinMedidor::all() as $c)
                  <option value="{{ $c->id }}"
                    {{ old('consumo_sin_medidor_id') == $c->id ? 'selected':'' }}>
                    {{ $c->categoria }}
                  </option>
                @endforeach
              </select>
              @error('consumo_sin_medidor_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- botones --}}
          <div class="mt-8 flex justify-end space-x-4">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
              Guardar cliente
            </button>
            <a href="{{ route('gestion_clientes.index', $ciudad) }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
              Cancelar
            </a>
          </div>
        </form>
      @endif
    </div>
  </x-app-layout>
