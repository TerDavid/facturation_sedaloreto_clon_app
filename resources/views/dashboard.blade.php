<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-[5vh] px-[5vw]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8
                    grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Reportes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Reportes') }}
                </div>
            </div>

            <!-- Card 2: Clientes (ahora link a la vista de selección de ciudad) -->
            <a href="{{ route('clientes.index') }}" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                            hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Clientes') }}
                </div>
                </div>
            </a>


            <a href="{{ route('tecnico.index') }}" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                            hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                  <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Personal Técnico') }}
                  </div>
                </div>
              </a>

                 <!-- Card 4: Sedes (ahora link a creación de planta_tratamiento) -->
                 <a href="{{ route('sede.index') }}" class="block">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                                hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                        <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                            {{ __('Sedes') }}
                        </div>
                    </div>
                </a>
        </div>
    </div>

</x-app-layout>
