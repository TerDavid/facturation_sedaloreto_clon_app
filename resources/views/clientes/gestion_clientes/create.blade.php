{{-- resources/views/clientes/gestion_clientes/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">
            Registrar cliente en
        </h2>
    </x-slot>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium"> Registrar cliente</h2>
    </div>

    <div
        class="mt-4 p-6 max-w-4xl   box relative p-5 before:absolute before:inset-0 before:mx-3 before:-mb-3 before:border before:border-foreground/10 before:bg-background/30 before:shadow-[0px_3px_5px_#0000000b] before:z-[-1] before:rounded-xl after:absolute after:inset-0 after:border after:border-foreground/10 after:bg-background after:shadow-[0px_3px_5px_#0000000b] after:rounded-xl after:z-[-1] after:backdrop-blur-md">
        {{-- 1) Selector de sector --}}
        {{-- <form method="GET" action="{{ route('gestion_clientes.create', $ciudad) }}"
            class="mb-6 flex items-end space-x-4">
            @csrf
            <div class="w-1/3">

                <x-form.label for="sector_id">
                    Elige primero un sector
                </x-form.label>
                <x-form.select id="sector_id" name="sector_id" onselect="onChangeCiudad(event)"
                    class="mt-1 block w-full   rounded">
                    <option value="">-- selecciona sector --</option>
                    @foreach ($sectores as $s)
                        <option value="{{ $s->id }}" {{ request('sector_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->sector }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Continuar
            </button>
        </form> --}}

        @if (true)
            {{-- 2) Formulario completo --}}
            <form method="POST" id="frm_filter" action="{{ route('gestion.clientes.store') }}">
                @csrf

                {{-- ocultos básicos --}}
                {{-- <input type="hidden" name="ciudad_id" value="{{ $ciudad->id }}"> --}}
                {{-- <input type="hidden" name="sector_id" value="{{ request('sector_id') }}"> --}}

                <div class="md:grid  md:grid-cols-2 flex flex-col  gap-2 md:gap-4">
                    {{-- Ciudad --}}
                    <div x-data>
                        <x-form.label for="ciudad_id">
                            Seleccionar ciudad
                        </x-form.label>
                        <x-form.select x-model="$store.selects.paisSelected" @change="$store.selects.cargarSectores()"
                            id="ciudad_id" name="ciudad_id" class="mt-1 block w-full rounded">
                            <option value="">-- selecciona ciudad --</option>
                            @foreach ($ciudades as $c)
                                <option value="{{ $c->id }}" {{ old('ciudad_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('ciudad_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data>
                        <x-form.label for="sector_id">
                            Seleccionar sector
                        </x-form.label>
                        <x-form.select @change="$store.selects.cargarManzanas()" x-model="$store.selects.sectorSelected"
                            x-bind:disabled="$store.selects.sectores.length === 0" id="sector_id" name="sector_id"
                            class="mt-1 block w-full rounded">
                            <option value="">-- selecciona sector --</option>
                            <template x-for="sector in $store.selects.sectores" :key="sector.id">
                                <option :value="sector.id" x-text="sector.sector"></option>
                            </template>
                        </x-form.select>
                        @error('sector_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Estado --}}
                    <div>
                        <x-form.label for="estado">
                            Estado
                        </x-form.label>
                        <x-form.select id="estado" name="estado" class="mt-4 block w-full rounded">
                            <option value="1" {{ old('estado') === '1' ? 'selected' : '' }}>Sin deuda</option>
                            <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                            <option value="2" {{ old('estado') === '2' ? 'selected' : '' }}>Deuda</option>
                            <option value="3" {{ old('estado') === '3' ? 'selected' : '' }}>Corte</option>
                        </x-form.select>
                        @error('estado')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div></div>

                    {{-- Código de suministro --}}
                    <div>
                        <x-form.label for="codigo_suministro">
                            Código de suministro
                        </x-form.label>
                        <x-input-text id="codigo_suministro" name="codigo_suministro" placeholder="00000" class="mt-4"
                            value="{{ old('codigo_suministro') }}" />
                        @error('codigo_suministro')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <x-form.label for="nombre">
                            Nombre
                        </x-form.label>
                        <x-input-text id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                            class="mt-4" />
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellido --}}
                    <div>
                        <x-form.label for="apellido">
                            Apellido
                        </x-form.label>
                        <x-input-text id="apellido" name="apellido" type="text" value="{{ old('apellido') }}"
                            class="mt-1 block w-full   rounded" />
                        @error('apellido')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DNI --}}
                    <div>
                        <x-form.label for="dni">
                            DNI
                        </x-form.label>
                        <x-input-text id="dni" name="dni" type="text" value="{{ old('dni') }}"
                            class="mt-1 block w-full   rounded" />
                        @error('dni')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Celular --}}
                    <div>
                        <x-form.label for="celular">
                            Celular
                        </x-form.label>
                        <x-input-text id="celular" name="celular" type="text" value="{{ old('celular') }}"
                            class="mt-1 block w-full   rounded" />
                        @error('celular')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <x-form.label for="correo">
                            Correo
                        </x-form.label>
                        <x-input-text id="correo" name="correo" type="email" value="{{ old('correo') }}"
                            class="mt-1 block w-full   rounded" />
                        @error('correo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="col-span-2">
                        <x-form.label for="direccion">
                            Dirección
                        </x-form.label>
                        <x-input-text id="direccion" name="direccion" type="text" value="{{ old('direccion') }}"
                            class="mt-1 block w-full   rounded" />
                        @error('direccion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Manzana --}}
                    <div x-data>
                        <x-form.label for="manzana_id">
                            Manzana
                        </x-form.label>
                        <x-form.select id="manzana_id" name="manzana_id"
                            x-bind:disabled="$store.selects.manzanas.length === 0" class="mt-1 block w-full   rounded">
                            <option value="">-- selecciona manzana --</option>
                            {{-- @foreach ($manzanas as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('manzana_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->manzana }}
                                </option>
                            @endforeach --}}
                            <template x-for="manzanas in $store.selects.manzanas" :key="manzanas.id">
                                <option :value="manzanas.id" x-text="manzanas.manzana"></option>
                            </template>
                        </x-form.select>
                        @error('manzana_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Medidor --}}
                    <div>
                        <x-form.label for="medidor_id">
                            Medidor
                        </x-form.label>
                        <x-form.select id="medidor_id" name="medidor_id" class="mt-1 block w-full   rounded">
                            <option value="">-- selecciona medidor --</option>
                            @foreach ($medidores as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('medidor_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->codigo_medidor }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('medidor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tarifa --}}
                    <div>
                        <x-form.label for="tarifa_id">
                            Tarifa aplicable
                        </x-form.label>
                        <x-form.select id="tarifa_id" name="tarifa_id" class="mt-1 block w-full   rounded"
                            {{-- :disabled="!old('medidor_id')" --}}>
                            <option value="">-- selecciona tarifa --</option>
                            @foreach ($tarifas as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('tarifa_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->categoria }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('tarifa_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Consumo sin medidor --}}
                    <div>
                        <x-form.label for="consumo_sin_medidor_id">
                            Consumo sin medidor
                        </x-form.label>
                        <x-form.select id="consumo_sin_medidor_id" name="consumo_sin_medidor_id"
                            class="mt-1 block w-full   rounded">
                            <option value="">-- selecciona opción --</option>
                            @foreach (\App\Models\ConsumoSinMedidor::all() as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('consumo_sin_medidor_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->categoria }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('consumo_sin_medidor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- botones --}}
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
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
    @section('scripts')
        <script>
            //document.addEventListener('DOMContentLoaded', () => {
                document.addEventListener('alpine:init', () => {
                    Alpine.store('selects', {
                        paisSelected: '',
                        sectores: [],
                        sectorSelected: '',
                        manzanas: [],

                        cargarSectores() {
                            this.sectores = [];
                            axios.get(`/api/ciudades/${this.paisSelected}/sectores`).then(response => {
                                console.log(response.data);
                                this.sectores = response.data;
                                console.log(this.sectores)
                            })

                        },
                        cargarManzanas() {
                            this.manzanas = [];
                            axios.get(`/api/sector/${this.sectorSelected}/manzanas`).then(response => {
                                this.manzanas = response.data;
                            })
                        }
                    })
                })

            //});
        </script>
    @endsection
</x-app-layout>
