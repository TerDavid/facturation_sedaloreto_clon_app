<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-4xl text-black dark:text-black leading-tight">
            {{ __('Listado de Bombas de Agua') }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-800 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('bomba-agua.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
            Nueva Bomba
        </a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
                <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">ID</th>
                        <th scope="col" class="px-6 py-3 text-center">Bomba</th>
                        <th scope="col" class="px-6 py-3 text-center">Ciudad</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bombas as $b)
                        <tr class="bg-blue-500 border-b border-blue-400">
                            <td class="px-6 py-4 text-center">{{ $b->id }}</td>
                            <td class="px-6 py-4 text-center font-medium whitespace-nowrap">
                                {{ $b->bomba }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $b->ciudad->nombre }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('bomba-agua.show', $b) }}"
                                   class="font-medium text-white hover:underline">Ver</a>
                                <a href="{{ route('bomba-agua.edit', $b) }}"
                                   class="font-medium text-white hover:underline">Editar</a>
                                <form action="{{ route('bomba-agua.destroy', $b) }}"
                                      method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="font-medium text-white hover:underline"
                                            onclick="return confirm('¿Seguro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bombas->links() }}
        </div>
    </div>
</x-app-layout>
