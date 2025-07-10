{{-- resources/views/clientes/gestion_clientes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Gestión de Clientes') }}
        </h2>
    </x-slot>
    <x-html.title-page>
        {{ __('Gestión de Clientes') }}
    </x-html.title-page>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div x-data="clienteManager()" class="py-6">
        <button @click="openForm('create')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            + Nuevo cliente
        </button>

        {{-- Modal --}}
        <div x-show="isOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-start justify-center pt-16 z-50">
            <div class="bg-white rounded-lg w-full max-w-2xl p-6 relative">
                <button @click="closeForm()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

                <h3 class="text-2xl font-bold mb-4"
                    x-text="mode==='create' ? 'Registrar nuevo cliente' : 'Editar cliente'"></h3>

                <form :action="formAction" method="POST" @submit="prepareSubmit(event)">
                    @csrf
                    <template x-if="mode==='edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    {{-- Cascada Ciudad → Sector → Manzana --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block mb-1">Ciudad</label>
                            <select name="ciudad_id" x-model="form.ciudad_id" @change="filterSectores()"
                                class="w-full p-2 border rounded" required>
                                <option value="">→ Selecciona ciudad</option>
                                <template x-for="c in ciudades" :key="c.id">
                                    <option :value="c.id" x-text="c.nombre"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1">Sector</label>
                            <select name="sector_id" x-model="form.sector_id" @change="filterManzanas()"
                                :disabled="!sectores.length" class="w-full p-2 border rounded" required>
                                <option value="">→ Selecciona sector</option>
                                <template x-for="s in sectores" :key="s.id">
                                    <option :value="s.id" x-text="s.sector"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1">Manzana</label>
                            <select name="manzana_id" x-model="form.manzana_id" @change="updateCode()"
                                :disabled="!manzanas.length" class="w-full p-2 border rounded" required>
                                <option value="">→ Selecciona manzana</option>
                                <template x-for="m in manzanas" :key="m.id">
                                    <option :value="m.id" x-text="m.manzana"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    {{-- Datos básicos --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label>Nombre</label>
                            <input name="nombre" x-model="form.nombre" class="w-full p-2 border rounded" required>
                        </div>
                        <div>
                            <label>Apellido</label>
                            <input name="apellido" x-model="form.apellido" class="w-full p-2 border rounded" required>
                        </div>
                        <div>
                            <label>DNI</label>
                            <input name="dni" x-model="form.dni" @input="updateCode()"
                                    class="w-full p-2 border rounded" required>
                            @error('dni')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label>Dirección</label>
                            <input name="direccion" x-model="form.direccion" class="w-full p-2 border rounded">
                        </div>
                        <div>
                            <label>Teléfono</label>
                            <input name="telefono" x-model="form.telefono" class="w-full p-2 border rounded">
                        </div>
                        <div>
                            <label>Correo</label>
                            <input type="email" name="email" x-model="form.email"
                                    class="w-full p-2 border rounded">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Medidor --}}
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="hidden" name="crear_medidor" :value="form.crear_medidor ? 'true' : 'false'">
                            <input type="checkbox" x-model="form.crear_medidor" class="form-checkbox">
                            <span class="ml-2">Registrar también medidor</span>
                        </label>
                    </div>

                    <div x-show="form.crear_medidor" class="space-y-4 mb-4">
                        <div>
                            <label>Código Medidor</label>
                            <input name="medidor_codigo" x-model="form.medidor_codigo" class="w-full p-2 border rounded"
                                :required="form.crear_medidor">
                        </div>
                        <div>
                            <label>Fecha instalación</label>
                            <input type="date" name="medidor_fecha_instalacion"
                                x-model="form.medidor_fecha_instalacion" class="w-full p-2 border rounded">
                        </div>
                        <div>
                            <label>Ubicación detallada</label>
                            <textarea name="ubicacion_detallada" x-model="form.ubicacion_detallada" class="w-full p-2 border rounded"></textarea>
                        </div>
                    </div>

                    {{-- Tarifa o Consumo --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div x-show="form.crear_medidor">
                            <label>Tarifa</label>
                            <select name="tarifa_id" x-model="form.tarifa_id" class="w-full p-2 border rounded"
                                :required="form.crear_medidor">
                                <option value="">→ Selecciona tarifa</option>
                                <template x-for="t in tarifas" :key="t.id">
                                    <option :value="t.id"
                                        x-text="`${t.categoria} – ${t.rango_min}–${t.rango_max ?? '∞'}`">
                                    </option>
                                </template>
                            </select>
                        </div>
                        <div x-show="!form.crear_medidor">
                            <label>Consumo estándar (sin medidor)</label>
                            <select name="consumo_sin_medidor_id" x-model="form.consumo_sin_medidor_id"
                                class="w-full p-2 border rounded" :required="!form.crear_medidor">
                                <option value="">→ Selecciona consumo</option>
                                <template x-for="c in consumos" :key="c.id">
                                    <option :value="c.id"
                                        x-text="`${c.categoria} – ${c.asignado_m3} m³/mes`">
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>

                    {{-- Código suministro --}}
                    <div class="mb-4">
                        <label>Código de Suministro</label>
                        <input name="code_suministro" x-model="form.code_suministro" readonly
                                class="w-full p-2 border rounded bg-gray-100 cursor-not-allowed">
                        @error('code_suministro')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeForm()"
                            class="px-4 py-2 border rounded">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded"
                            x-text="mode==='create' ? 'Guardar' : 'Actualizar'"></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabla --}}
        <x-html.box class="mt-6">
            <div class="overflow-x-auto rounded">
                <x-table class="w-full table-auto" id="table-clientes">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Ciudad</th>
                            <th class="px-4 py-2">Sector</th>
                            <th class="px-4 py-2">Manzana</th>
                            <th class="px-4 py-2">Código suministro</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Apellido</th>
                            <th class="px-4 py-2">DNI</th>
                            <th class="px-4 py-2">Teléfono</th>
                            <th class="px-4 py-2">Correo</th>
                            <th class="px-4 py-2">Categoría</th>
                            <th class="px-4 py-2">Medidor</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </x-table>
            </div>
        </x-html.box>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            // table-clientes
        });
    </script>
    <script>
        function openForm2(mode, cliente = null) {

        }

        function clienteManager() {
            return {
                ciudades: @json($ciudades),
                allSectores: @json($allSectores),
                allManzanas: @json($allManzanas),
                tarifas: @json($tarifas),
                consumos: @json($consumos),

                sectores: [],
                manzanas: [],
                isOpen: false,
                mode: 'create',

                form: {
                    id: null,
                    ciudad_id: '',
                    sector_id: '',
                    manzana_id: '',
                    nombre: '',
                    apellido: '',
                    dni: '',
                    direccion: '',
                    telefono: '',
                    email: '',
                    crear_medidor: false,
                    medidor_codigo: '',
                    medidor_fecha_instalacion: '',
                    ubicacion_detallada: '',
                    tarifa_id: '',
                    consumo_sin_medidor_id: '',
                    categoria: '',
                    code_suministro: ''
                },

                init() {
                    let table = new DataTable('#table-clientes', {
                        // dom: "fltp<'dt-block-top'fl><'dt-block-content't><'dt-block-bottom'i<p>>r",
                        dom: "<'table-tool'<l><'flex justify-end'f>><t><p>",
                        // pagingType: "simple",
                        language: {
                            paginate: {
                                previous: ` <svg
                            width="18"
                            height="18"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                fillRule="evenodd"
                                clipRule="evenodd"
                                d="M12.2574 5.59165C11.9324 5.26665 11.4074 5.26665 11.0824 5.59165L7.25742 9.41665C6.93242 9.74165 6.93242 10.2667 7.25742 10.5917L11.0824 14.4167C11.4074 14.7417 11.9324 14.7417 12.2574 14.4167C12.5824 14.0917 12.5824 13.5667 12.2574 13.2417L9.02409 9.99998L12.2574 6.76665C12.5824 6.44165 12.5741 5.90832 12.2574 5.59165Z"
                                fill="#969696"
                            />
                            </svg>`,
                                next: `  <svg
                            width="18"
                            height="18"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                fillRule="evenodd"
                                clipRule="evenodd"
                                d="M7.74375 5.2448C7.41875 5.5698 7.41875 6.0948 7.74375 6.4198L10.9771 9.65314L7.74375 12.8865C7.41875 13.2115 7.41875 13.7365 7.74375 14.0615C8.06875 14.3865 8.59375 14.3865 8.91875 14.0615L12.7437 10.2365C13.0687 9.91147 13.0687 9.38647 12.7437 9.06147L8.91875 5.23647C8.60208 4.9198 8.06875 4.9198 7.74375 5.2448Z"
                                fill="#969696"
                            />
                            </svg>`,
                            },
                        },
                        destroy: true,

                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: `{{ route('gestion_clientes.datatable') }}`,

                            error: function(xhr, error, thrown) {

                                if (!["abort"].some((v) => v === thrown)) {

                                }
                            },
                        },
                        order: [
                            [1, "asc"]
                        ],
                        createdRow: (r, d, i) => {
                            //   new Vue().$mount(r.querySelector(".cell-options"));
                        },
                        columns: [{
                                data: "ciudad",
                                title: "Ciudad",
                            },
                            {
                                data: "sector",
                                title: "Sector",
                            },
                            {
                                data: "manzana",
                                title: "Manzana",

                            },
                            {
                                data: "code_suministro",
                                title: "Código suministro",
                            },
                            {
                                data: "nombre",
                                title: "Nombre",
                            },
                            {
                                data: "apellido",
                                title: "Apellido",
                            },
                            {
                                data: "dni",
                                title: "DNI",
                            },
                            {
                                data: "telefono",
                                title: "Teléfono",
                            },
                            {
                                data: "email",
                                title: "Correo",
                            },
                            {
                                data: "categoria",
                                title: "Categoría",
                            },
                            {
                                data: "id",
                                title: "Medidor",
                                render: (d, t, r) => {
                                    return r.tarifa_id ? 'Con medidor' : 'Sin medidor';
                                }
                            },
                            {
                                data: "id",
                                title: "Acciones",
                                render: (d, t, r) => {

                                    // const t = JSON.stringify(r)
                                    return `<button data class="btn-accion  text-blue-400 hover:underline" data-action="edit"  >Editar</button>
                                    <form method="POST" action="/clientes/gestion/${r.id}" class="inline" onsubmit="return confirm('¿Eliminar cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Eliminar</button>
                                    </form>`;
                                }
                            },

                        ],
                        initComplete: function(a, b, c) {

                        },
                    });
                    let self = this;
                    table.on('click', '.btn-accion', function(e) {

                        //get row data
                        let row = table.row($(this).closest('tr'));
                        let data = row.data();
                        self.openForm('edit', {
                            id: data.id,
                            ciudad_id: data.ciudad_id,
                            sector_id: data.sector_id,
                            manzana_id: data.manzana_id,
                            nombre: data.nombre,
                            apellido: data.apellido,
                            dni: data.dni,
                            direccion: data.direccion,
                            telefono: data.telefono,
                            email: data.email,
                            crear_medidor: !!data.tarifa_id,  // <-- aquí
                            medidor_codigo: data.medidor_codigo,
                            medidor_fecha_instalacion: data.medidor_fecha_instalacion,
                            ubicacion_detallada: data.ubicacion_detallada,
                            tarifa_id: data.tarifa_id ?? '',
                            consumo_sin_medidor_id: data.consumo_sin_medidor_id ?? '',
                            categoria: data.categoria,
                            code_suministro: data.code_suministro
                        });
                    });
                },
                filterSectores() {
                    axios.get(`/api/ciudades/${this.form.ciudad_id}/sectores`)
                        .then(response => {
                            this.sectores = response.data;
                            this.form.sector_id = '';
                            this.manzanas = [];
                            this.form.manzana_id = '';
                            this.updateCode();
                        });
                },

                filterManzanas() {
                    axios.get(`/api/sector/${this.form.sector_id}/manzanas`)
                        .then(response => {
                            this.manzanas = response.data;
                            this.form.manzana_id = '';
                            this.updateCode();
                        });
                },

                updateCode() {
                    if (!this.form.ciudad_id ||
                        !this.form.sector_id ||
                        !this.form.manzana_id ||
                        !this.form.dni
                    ) {
                        this.form.code_suministro = '';
                        return;
                    }
                    this.form.code_suministro =
                        `${this.form.ciudad_id}${this.form.sector_id}${this.form.manzana_id}${this.form.dni}`;
                },

                openForm(mode, cliente = null) {
                    this.mode = mode;
                    if (mode === 'create') {
                        Object.assign(this.form, {
                            id: null,
                            ciudad_id: '',
                            sector_id: '',
                            manzana_id: '',
                            nombre: '',
                            apellido: '',
                            dni: '',
                            direccion: '',
                            telefono: '',
                            email: '',
                            crear_medidor: false,
                            medidor_codigo: '',
                            medidor_fecha_instalacion: '',
                            ubicacion_detallada: '',
                            tarifa_id: '',
                            consumo_sin_medidor_id: '',
                            categoria: '',
                            code_suministro: ''
                        });
                        this.sectores = [];
                        this.manzanas = [];
                        this.isOpen = true;
                    } else {
                        this.form.crear_medidor = Boolean(cliente.tarifa_id)

                        this.sectores = this.allSectores.filter(s =>
                        s.reservorio?.bomba?.id_ciudades == cliente.ciudad_id
                        )


                        // this.sectores = this.allSectores.filter(s =>
                        //     s.reservorio?.bomba?.id_ciudades == cliente.ciudad_id
                        // );
                        this.manzanas = this.allManzanas.filter(m =>
                            +m.id_sector == +cliente.sector_id
                        );

                        Object.assign(this.form, cliente);

                        this.$nextTick(() => {
                            this.updateCode();
                            this.isOpen = true;
                        });
                    }
                },

                closeForm() {
                    this.isOpen = false;
                },

                prepareSubmit(e) {
                    this.updateCode();
                },

                get formAction() {
                    return this.mode === 'create' ?
                        '{{ route('gestion.clientes.store') }}' :
                        `/clientes/gestion/${this.form.id}`;
                }
            };
        }
    </script>
</x-app-layout>
