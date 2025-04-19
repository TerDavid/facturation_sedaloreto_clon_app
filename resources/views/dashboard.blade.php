<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
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

            <!-- Card 4: Sedes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                    {{ __('Sedes') }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
