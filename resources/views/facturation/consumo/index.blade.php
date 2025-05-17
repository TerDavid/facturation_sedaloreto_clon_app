{{-- resources/views/facturation/consumo/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Consumos Registrados') }}
        </h2>
    </x-slot>

    <x-html.title-page>
        {{ __('Consumos Registrados') }}
    </x-html.title-page>

    <style>[x-cloak] { display: none !important; }</style>

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

    <div x-data="facturaManager()" class="py-6 space-y-6">
        {{-- Botones principales --}}
        <div class="flex space-x-2">
            <a href="{{ route('facturation.consumo.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
              + Nuevo Consumo
            </a>
            <button @click="openPopup()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
              Emitir Facturas
            </button>
            <button @click="openExportPopup()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
              Exportar Listas
            </button>
            <button @click="openImportPopup()"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
              Importar Consumos
            </button>
        </div>

        {{-- Pop-up: Emitir Facturas --}}
        <div x-show="isPopupOpen" x-cloak
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <button @click="closePopup()"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
            <h3 class="text-xl font-bold mb-4">Filtrar para emitir</h3>

            <div class="space-y-4">
              <div>
                <label class="block mb-1">Ciudad</label>
                <select x-model="form.ciudad_id" @change="filterSectores()"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todas</option>
                  <template x-for="c in ciudades" :key="c.id">
                    <option :value="c.id" x-text="c.nombre"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="block mb-1">Sector</label>
                <select x-model="form.sector_id" @change="filterManzanas()"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todos</option>
                  <template x-for="s in sectores" :key="s.id">
                    <option :value="s.id" x-text="s.sector"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="block mb-1">Manzana</label>
                <select x-model="form.manzana_id"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todas</option>
                  <template x-for="m in manzanas" :key="m.id">
                    <option :value="m.id" x-text="m.manzana"></option>
                  </template>
                </select>
              </div>
              <div class="flex justify-end space-x-2 mt-4">
                <button @click="closePopup()"
                        class="px-4 py-2 border rounded">Cancelar</button>
                <button @click="submitEmit()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                  Emitir
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- Pop-up: Exportar Listas --}}
        <div x-show="isExportPopupOpen" x-cloak
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <button @click="closeExportPopup()"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
            <h3 class="text-xl font-bold mb-4">Filtrar para exportar</h3>

            <div class="space-y-4">
              <div>
                <label class="block mb-1">Ciudad</label>
                <select x-model="exportForm.ciudad_id" @change="filterSectoresExport()"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todas</option>
                  <template x-for="c in ciudades" :key="c.id">
                    <option :value="c.id" x-text="c.nombre"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="block mb-1">Sector</label>
                <select x-model="exportForm.sector_id" @change="filterManzanasExport()"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todos</option>
                  <template x-for="s in sectores" :key="s.id">
                    <option :value="s.id" x-text="s.sector"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="block mb-1">Manzana</label>
                <select x-model="exportForm.manzana_id"
                        class="w-full p-2 border rounded">
                  <option value="">→ Todas</option>
                  <template x-for="m in manzanas" :key="m.id">
                    <option :value="m.id" x-text="m.manzana"></option>
                  </template>
                </select>
              </div>
              <div>
                <label class="block mb-1">Mes</label>
                <input type="month" x-model="exportForm.month"
                       class="w-full p-2 border rounded"/>
              </div>
              <div class="flex justify-end space-x-2 mt-4">
                <button @click="closeExportPopup()"
                        class="px-4 py-2 border rounded">Cancelar</button>
                <button @click="submitExport()"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                  Exportar
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- Pop-up: Importar Consumos --}}
        <div x-show="isImportPopupOpen" x-cloak
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <button @click="closeImportPopup()"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
            <h3 class="text-xl font-bold mb-4">Importar desde Excel</h3>
            <form action="{{ route('facturation.consumo.importar') }}"
                  method="POST"
                  enctype="multipart/form-data">
              @csrf
              <div class="mb-4">
                <label class="block mb-1">Archivo (.xls, .xlsx)</label>
                <input type="file" name="file" accept=".xls,.xlsx"
                       class="w-full p-2 border rounded" required>
              </div>
              <div class="flex justify-end space-x-2">
                <button @click.prevent="closeImportPopup()"
                        type="button"
                        class="px-4 py-2 border rounded">Cancelar</button>
                <button type="submit"
                        class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded">
                  Importar
                </button>
              </div>
            </form>
          </div>
        </div>

        {{-- Tabla de consumos --}}
        <x-html.box class="mt-6">
          <div class="overflow-x-auto rounded">
            <x-table class="w-full table-auto">
              <thead class="bg-gray-800 text-white">
                <tr>
                  <th class="px-4 py-2">ID</th>
                  <th class="px-4 py-2">Código Sum.</th>
                  <th class="px-4 py-2">Ciudad</th>
                  <th class="px-4 py-2">Sector</th>
                  <th class="px-4 py-2">Manzana</th>
                  <th class="px-4 py-2">Cliente</th>
                  <th class="px-4 py-2">Dirección</th>
                  <th class="px-4 py-2">m³ Consumidos</th>
                  <th class="px-4 py-2">Fecha / Hora</th>
                  <th class="px-4 py-2">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($consumos as $c)
                  <tr class="border-t border-gray-200">
                    <td class="px-4 py-2">{{ $c->id }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->code_suministro }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->manzana->ciudad->nombre }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->manzana->sector->sector }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->manzana->manzana }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->nombre }} {{ $c->cliente->apellido }}</td>
                    <td class="px-4 py-2">{{ $c->cliente->direccion ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $c->m3_consumidos ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $c->hora_registro_consumo ?? '-' }}</td>
                    <td class="px-4 py-2 space-x-2">
                      <a href="{{ route('facturation.consumo.edit', $c) }}"
                         class="text-blue-600 hover:underline">Editar</a>
                      <form action="{{ route('facturation.consumo.destroy', $c) }}"
                            method="POST" class="inline"
                            onsubmit="return confirm('¿Eliminar este consumo?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Borrar</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </x-table>
          </div>
        </x-html.box>
    </div>

    <script>
    function facturaManager() {
      return {
        // datos para filtros
        ciudades:    @json($ciudades),
        allSectores: @json($allSectores),
        allManzanas: @json($allManzanas),
        sectores:    [],
        manzanas:    [],

        // Emitir
        isPopupOpen: false,
        form: { ciudad_id: '', sector_id: '', manzana_id: '' },
        openPopup()  { this.isPopupOpen = true;  },
        closePopup() { this.isPopupOpen = false; },
        filterSectores() {
          this.sectores = this.allSectores.filter(s =>
            s.id_ciudad == this.form.ciudad_id
          );
          this.form.sector_id = '';
          this.manzanas       = [];
          this.form.manzana_id= '';
        },
        filterManzanas() {
          this.manzanas = this.allManzanas.filter(m =>
            m.id_sector == this.form.sector_id
          );
          this.form.manzana_id = '';
        },
        submitEmit() {
          axios.post('{{ route("facturation.consumo.emitir") }}', this.form)
               .then(res => {
                 alert(res.data.message);
                 this.closePopup();
                 window.location.reload();
               })
               .catch(console.error);
        },

        // Exportar
        isExportPopupOpen: false,
        exportForm: { ciudad_id: '', sector_id: '', manzana_id: '', month: '' },
        openExportPopup()  { this.isExportPopupOpen = true;  },
        closeExportPopup() { this.isExportPopupOpen = false; },
        filterSectoresExport() {
          this.sectores = this.allSectores.filter(s =>
            s.id_ciudad == this.exportForm.ciudad_id
          );
          this.exportForm.sector_id = '';
          this.manzanas             = [];
          this.exportForm.manzana_id= '';
        },
        filterManzanasExport() {
          this.manzanas = this.allManzanas.filter(m =>
            m.id_sector == this.exportForm.sector_id
          );
          this.exportForm.manzana_id = '';
        },
        submitExport() {
          if (!this.exportForm.month) {
            this.exportForm.month = new Date().toISOString().slice(0,7);
          }
          const qs = new URLSearchParams(this.exportForm).toString();
          window.location = '{{ route("facturation.consumo.exportar") }}?' + qs;
        },

        // Importar
        isImportPopupOpen: false,
        openImportPopup()  { this.isImportPopupOpen = true;  },
        closeImportPopup() { this.isImportPopupOpen = false; },
      }
    }
    </script>
</x-app-layout>
