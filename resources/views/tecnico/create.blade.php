<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Nuevo Personal Técnico') }}
      </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw] space-y-8">
      {{-- Componente Alpine para el modal --}}
      <div
        x-data="{ open: false }"
        x-cloak
        x-init="@json($errors->any()) && (open = true)"
      >
        <!-- Botón para abrir modal -->
        <button
          @click="open = true"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md transition"
        >
          {{ __('Registrar Nuevo Técnico') }}
        </button>

        <!-- Modal (backdrop + ventana) -->
        <div
          x-show="open"
          x-transition.opacity
          class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
          <div
            @click.away="open = false"
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6"
          >
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ __('Nuevo Técnico') }}
              </h3>
              <button @click="open = false" class="text-gray-600 hover:text-gray-900">
                &times;
              </button>
            </div>

            <form action="{{ route('tecnico.store') }}" method="POST" novalidate>
              @csrf

              <div class="grid grid-cols-1 gap-4">
                <!-- Nombre -->
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Nombre') }}
                  </label>
                  <input
                    id="nombre"
                    name="nombre"
                    type="text"
                    value="{{ old('nombre') }}"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Apellido -->
                <div>
                  <label for="apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Apellido') }}
                  </label>
                  <input
                    id="apellido"
                    name="apellido"
                    type="text"
                    value="{{ old('apellido') }}"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('apellido')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Usuario -->
                <div>
                  <label for="usuario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Usuario') }}
                  </label>
                  <input
                    id="usuario"
                    name="usuario"
                    type="text"
                    value="{{ old('usuario') }}"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('usuario')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Email -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Correo') }}
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Contraseña -->
                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Contraseña') }}
                  </label>
                  <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Confirmar Contraseña') }}
                  </label>
                  <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                  />
                  @error('password_confirmation')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <!-- Rol fijo -->
                <input type="hidden" name="role_id" value="2" />
              </div>

              <div class="mt-6 flex justify-end space-x-3">
                <button
                  type="button"
                  @click="open = false"
                  class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md"
                >
                  {{ __('Cancelar') }}
                </button>
                <button
                  type="submit"
                  class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-md"
                >
                  {{ __('Guardar Técnico') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      {{-- Tabla con el listado de técnicos --}}
      <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nombre</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Apellido</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Usuario</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Correo</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($tecnicos as $tecnico)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($tecnicos->currentPage()-1)*$tecnicos->perPage() }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $tecnico->nombre }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $tecnico->apellido }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $tecnico->usuario }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $tecnico->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                  <a href="{{ route('tecnico.edit', $tecnico) }}"
                     class="text-blue-600 hover:underline">
                    Editar
                  </a>
                  <form action="{{ route('tecnico.destroy', $tecnico) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('¿Eliminar este técnico?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:underline">
                      Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- Paginación --}}
        <div class="px-6 py-4">
          {{ $tecnicos->links() }}
        </div>
      </div>
    </div>
</x-app-layout>
