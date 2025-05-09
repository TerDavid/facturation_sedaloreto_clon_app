<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Manzanas') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('manzana.create', ['sector_id' => request('sector_id')]) }}"
           class="px-4 py-2 bg-blue-600 hover:bg-green-700 text-white rounded">
            Crear Manzana
        </a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
                <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">ID</th>
                        <th scope="col" class="px-6 py-3 text-center">Manzana</th>
                        <th scope="col" class="px-6 py-3 text-center">Sector</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($manzanas as $manzana)
                        <tr class="bg-blue-500 border-b border-blue-400">
                            <td class="px-6 py-4 text-center">{{ $manzana->id }}</td>
                            <td class="px-6 py-4 text-center font-medium text-blue-50 whitespace-nowrap">
                                {{ $manzana->manzana }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $manzana->sector->sector }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('manzana.edit', $manzana) }}"
                                   class="font-medium text-white hover:underline">Editar</a>
                                <form action="{{ route('manzana.destroy', $manzana) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar esta manzana?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="font-medium text-white hover:underline">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-300">
                                No hay manzanas creadas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
