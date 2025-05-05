<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Personal Técnico') }}
        </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Nuevo Personal -->
            <a href="{{ route('tecnico.create') }}" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ __('Nuevo Personal') }}
                    </div>
                </div>
            </a>

            <!-- Asignar Personal -->
            <a href="{{ route('tecnico.assign') }}" class="block">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center font-semibold">
                        {{ __('Asignar Personal') }}
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
