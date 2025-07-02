<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black leading-tight">
            {{ __('Emitir') }}
        </h2>
    </x-slot>

    <x-html.title-page>
        {{ __('Emitir') }}
    </x-html.title-page>
    @php
        $ubigeo = "{$stablecimiento->district->description} - {$stablecimiento->province->description} - {$stablecimiento->department->description}";
    @endphp
    <div class="container w-full  mx-auto pt-20" x-data="documentsEmit">
     

        <!-- Encabezado -->
        <div class="w-full px-4 md:px-6 py-6 bg-white rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row  items-center">
                <img src="https://pagoseguroiquitos.sedaloreto.com.pe/img/logochico.png" alt="Logo" class=" mr-6">
                <div class="">
                    <p class="text-lg font-bold">{{ $company->trade_name }}</p>
                    <p class="text-sm">{{ $stablecimiento->address }}</p>
                    <p class="text-sm">{{ $ubigeo }}</p>
                    <p class="text-sm">{{ $stablecimiento->email }}</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="" method="post" x-on:submit.prevent="onClickGenerar" id="form-emitir">
            <div class="w-full px-4 md:px-6 py-6 bg-white rounded-lg shadow-md mt-4">
                <!-- Sección de filtros -->
                <div class="grid grid-cols-1 md:grid-cols-8 gap-4 mb-4">
                    <div class="col-span-1 md:col-span-2">
                        <label for="tipo_comprobante" class="block text-sm font-medium text-gray-700">Tipo de
                            comprobante</label>
                        <select id="tipo_comprobante" name="tipo_comprobante" x-model="selectedTipoComprobante"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <template x-for="tipo_comprobante in tipo_comprobante" :key="tipo_comprobante.id">
                                <option :value="tipo_comprobante.id" x-text="tipo_comprobante.description"></option>
                            </template>
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="establecimiento"
                            class="block text-sm font-medium text-gray-700">Establecimiento</label>
                        <select id="establecimiento" name="establecimiento"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <template x-for="establecimiento in establecimientos" :key="establecimiento.id">
                                <option :value="establecimiento.id" x-text="establecimiento.description"></option>
                            </template>
                        </select>
                    </div>
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="tipo_operacion" class="block text-sm font-medium text-gray-700">Tipo Operación</label>
                    <input type="hidden" id="tipo_operacion" name="tipo_operacion" value="0101"/>
                        
                    <select id="tipo_operacion" name="tipo_operacion"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option selected>Venta interna</option>
                        <option>Venta externa</option>
                    </select>
                </div> --}}
                    <div class="col-span-1 md:col-span-2">
                        <label for="serie" class="block text-sm font-medium text-gray-700">Serie</label>
                        <select id="serie" name="serie"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <template x-for="serie in filteredSeries" :key="serie.id">
                                <option :value="serie.id" x-text="serie.number"></option>
                            </template>
                        </select>
                    </div>
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="moneda" class="block text-sm font-medium text-gray-700">Moneda</label>
                    <select id="moneda" name="moneda"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option selected>Soles</option>
                        <option>Dólares</option>
                    </select>
                </div> --}}
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="tipo_cambio" class="block text-sm font-medium text-gray-700">Tipo de cambio</label>
                    <input type="text" id="tipo_cambio" name="tipo_cambio" value="3.845"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div> --}}
                </div>

                <!-- Sección de cliente -->

                <div class="grid grid-cols-1 md:grid-cols-8 gap-4 mb-4">

                    <div class="col-span-1 md:col-span-4">
                        <div class="flex items-center justify-between">
                            <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <button type="button"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                x-on:click="$dispatch('open-modal', 'basic-dialogx')">
                                Buscar cliente
                            </button>
                        </div>
                        <input type="hidden" id="cliente" name="cliente" value="" />
                        <input readonly type="text" id="cliente_name" name="cliente_name" value=""
                            placeholder="Seleccionar cliente"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                    </div>
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="orden_compra" class="block text-sm font-medium text-gray-700">Orden Compra</label>
                    <input type="text" id="orden_compra" name="orden_compra"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div> --}}
                    <div class="col-span-1 md:col-span-2">
                        <label for="fecha_emision" class="block text-sm font-medium text-gray-700">Fecha de
                            emisión</label>
                        <input type="date" id="fecha_emision" name="fecha_emision" value="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de
                        vencimiento</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div> --}}
                </div>

                <!-- Sección de estado de pago -->
                <div class="grid grid-cols-1 md:grid-cols-8 gap-4 mb-4">
                    {{-- <div class="col-span-1 md:col-span-2">
                    <label for="estado_pago" class="block text-sm font-medium text-gray-700">Estado de pago</label>
                    <select id="estado_pago" name="estado_pago"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option selected>Contado</option>
                        <option>Credito</option>
                    </select>
                </div> --}}
                    <div class="col-span-1 md:col-span-6">
                        <label for="info_adicional" class="block text-sm font-medium text-gray-700">Información
                            Adicional</label>
                        <textarea id="info_adicional" name="info_adicional" rows="3"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>
                </div>

                <!-- Sección de método de pago -->
                <div class="grid grid-cols-1 md:grid-cols-8 gap-4 mb-4">
                    <div class="col-span-1 md:col-span-2">
                        <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option selected>Efectivo</option>
                            <option>Tarjeta de crédito</option>
                        </select>
                    </div>
                    {{-- <div class="col-span-1 md:col-span-3">
                    <label for="cuenta_bancaria" class="block text-sm font-medium text-gray-700">Cuenta Bancaria
                        *</label>
                    <select id="cuenta_bancaria" name="cuenta_bancaria"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option selected>Caja General | Efectivo</option>
                        <option>Otra cuenta</option>
                    </select>
                </div> --}}
                    <div class="col-span-1 md:col-span-3">
                        <label for="valor_recibido" class="block text-sm font-medium text-gray-700">Valor recibido
                            *</label>
                        <input type="number" id="valor_recibido" name="valor_recibido" value="0" placeholder="0"
                            min="0" step="0.01" required
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Tabla de productos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripción</th>

                                {{-- <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Unidad</th> --}}
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio Unitario</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alcantarillado</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cargo fijo</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Aquí puedes agregar filas dinámicamente -->
                            <template x-for="consumo in Alpine.store('documentsEmitConsumo').resultConsumo.consumos"
                                :key="consumo.id">
                                <tr>
                                    <td x-text="consumo.id"></td>
                                    <td x-text="$store.documentsEmitConsumo.resultConsumo.tarifa.categoria"></td>
                                    <td x-text="consumo.m3_consumidos"></td>
                                    <td x-text="$store.documentsEmitConsumo.resultConsumo.tarifa.tarifa_agua"></td>
                                    <td
                                        x-text="$store.documentsEmitConsumo.resultConsumo.tarifa.tarifa_alcantarillado">
                                    </td>
                                    <td x-text="$store.documentsEmitConsumo.resultConsumo.tarifa.cargo_fijo"></td>
                                    <td x-text="consumo.valor"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <!-- Total Section -->
                <div class="mt-4 flex justify-end">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold mr-4">Total a Pagar:</span>
                            <span class="text-xl font-bold text-blue-600"
                                x-text="'S/ ' + Alpine.store('documentsEmitConsumo').resultConsumo.consumos.reduce((sum, consumo) => sum + parseFloat(consumo.valor), 0).toFixed(2)"></span>
                        </div>
                    </div>
                </div>
                <!-- Botón Agregar Producto -->
                {{-- <div class="mt-4">
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Agregar Producto
                </button>
            </div> --}}

                <!-- Botón Cancelar -->
                <div class="mt-4 text-right">
                    <button type="button"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Cancelar
                    </button>
                    <!-- Botón Generar -->
                    <button type="button" type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded shadow ml-2"
                        x-on:click="onClickGenerar">
                        Generar
                    </button>
                    <!-- Botón de prueba toast -->
                    <button type="button"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded shadow ml-2"
                        x-on:click="$store.toast.success('¡Éxito! Factura generada correctamente')">
                        Test Success
                    </button>
                    <button type="button"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded shadow ml-2"
                        x-on:click="$store.toast.error('Error al procesar la factura')">
                        Test Error
                    </button>
                </div>
            </div>
        </form>
    </div>
    <x-html.dialog id="basic-dialogx" title="Buscar cliente">
        <p class="opacity-80">
        <div class="w-full" x-data="searchClient">
            <!-- Search input -->
            <div class="relative mb-4">
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Buscar cliente..." x-model="searchQuery" @input="searchClients">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
            </div>

            <!-- Results table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                DNI
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dirección
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        <template x-for="client in searchResults" :key="client.id">
                            <tr x-on:click="selectClient(client)" class="cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="client.dni">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="client.nombre">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                    x-text="client.direccion">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button x-on:click="selectClient(client)"
                                        class="text-blue-600 hover:text-blue-900">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        </p>
    </x-html.dialog>
    @section('scripts')
        @vite('resources/js/modules/facturacion.js')
    @endsection
</x-app-layout>
