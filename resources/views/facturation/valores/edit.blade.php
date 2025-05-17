{{-- resources/views/facturation/valores/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-bold text-4xl text-black leading-tight">
        {{ __('Editar Valores de Tarifas y Consumos Sin Medidor') }}
      </h2>
    </x-slot>

    <x-html.title-page>
      {{ __('Valores Generales') }}
    </x-html.title-page>

    {{-- Mensajes --}}
    @if(session('success'))
      <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif
    @if($errors->any())
      <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="py-6">
      <form action="{{ route('valores.updateAll') }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        {{-- Tarifas --}}
        <x-html.box>
          <h3 class="text-xl font-semibold mb-4">Tarifas (Con Medidor)</h3>
          <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white">
              <thead class="bg-gray-800 text-white">
                <tr>
                  <th class="px-4 py-2">Categoría</th>
                  <th class="px-4 py-2">Rango</th>
                  <th class="px-4 py-2">Agua (S/ m³)</th>
                  <th class="px-4 py-2">Alcantarillado (S/ m³)</th>
                  <th class="px-4 py-2">Cargo Fijo (S/ mes)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tarifas as $t)
                  <tr class="border-t">
                    <td class="px-4 py-2">{{ $t->categoria }}</td>
                    <td class="px-4 py-2">
                      {{ $t->rango_min }}
                      @if($t->rango_max) – {{ $t->rango_max }} @else + @endif
                    </td>
                    <td class="px-4 py-2">
                      <input type="text"
                             name="tarifas[{{ $t->id }}][tarifa_agua]"
                             value="{{ old("tarifas.{$t->id}.tarifa_agua", $t->tarifa_agua) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                    <td class="px-4 py-2">
                      <input type="text"
                             name="tarifas[{{ $t->id }}][tarifa_alcantarillado]"
                             value="{{ old("tarifas.{$t->id}.tarifa_alcantarillado", $t->tarifa_alcantarillado) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                    <td class="px-4 py-2">
                      <input type="text"
                             name="tarifas[{{ $t->id }}][cargo_fijo]"
                             value="{{ old("tarifas.{$t->id}.cargo_fijo", $t->cargo_fijo) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </x-html.box>

        {{-- Consumos Sin Medidor --}}
        <x-html.box>
          <h3 class="text-xl font-semibold mb-4">Consumos Sin Medidor</h3>
          <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white">
              <thead class="bg-gray-800 text-white">
                <tr>
                  <th class="px-4 py-2">Categoría</th>
                  <th class="px-4 py-2">Asignado m³</th>
                  <th class="px-4 py-2">&lt;5h/día</th>
                  <th class="px-4 py-2">≥5h/día</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cs as $c)
                  <tr class="border-t">
                    <td class="px-4 py-2">{{ $c->categoria }}</td>
                    <td class="px-4 py-2">
                      <input type="number"
                             name="cs[{{ $c->id }}][asignado_m3]"
                             value="{{ old("cs.{$c->id}.asignado_m3", $c->asignado_m3) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                    <td class="px-4 py-2">
                      <input type="number"
                             name="cs[{{ $c->id }}][asignado_m3_menos_5h]"
                             value="{{ old("cs.{$c->id}.asignado_m3_menos_5h", $c->asignado_m3_menos_5h) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                    <td class="px-4 py-2">
                      <input type="number"
                             name="cs[{{ $c->id }}][asignado_m3_5h_o_mas]"
                             value="{{ old("cs.{$c->id}.asignado_m3_5h_o_mas", $c->asignado_m3_5h_o_mas) }}"
                             class="w-full border p-2 rounded"/>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </x-html.box>

        <div class="flex justify-end">
          <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Guardar Todos los Valores
          </button>
        </div>
      </form>
    </div>
  </x-app-layout>
