<x-app-layout>
    <div class="mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Dashboard</h2>
    </div>

    <div class="py-[5vh] px-[5vw]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8
                    grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Reportes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Reportes') }}
                </div>
            </div>

            <!-- Card 2: Clientes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Clientes') }}
                </div>
            </div>

            <!-- Card 3: Personal Técnico -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Personal Técnico') }}
                </div>
            </div>

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
