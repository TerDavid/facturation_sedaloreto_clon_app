<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Técnico') }}
      </h2>
    </x-slot>

    <div class="py-8 px-6 max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow">
      <form action="{{ route('tecnico.update', $tecnico) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-4">
          <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Nombre') }}
          </label>
          <input
            id="nombre"
            name="nombre"
            type="text"
            value="{{ old('nombre', $tecnico->nombre) }}"
            required
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('nombre')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Apellido --}}
        <div class="mb-4">
          <label for="apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Apellido') }}
          </label>
          <input
            id="apellido"
            name="apellido"
            type="text"
            value="{{ old('apellido', $tecnico->apellido) }}"
            required
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('apellido')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Usuario --}}
        <div class="mb-4">
          <label for="usuario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Usuario') }}
          </label>
          <input
            id="usuario"
            name="usuario"
            type="text"
            value="{{ old('usuario', $tecnico->usuario) }}"
            required
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('usuario')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Correo') }}
          </label>
          <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $tecnico->email) }}"
            required
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('email')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Contraseña nueva (opcional) --}}
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Nueva contraseña (dejar en blanco para no cambiar)') }}
          </label>
          <input
            id="password"
            name="password"
            type="password"
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div class="mb-6">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Confirmar nueva contraseña') }}
          </label>
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            class="mt-1 block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          @error('password_confirmation')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-3">
          <a
            href="{{ route('tecnico.index') }}"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md"
          >
            {{ __('Cancelar') }}
          </a>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md"
          >
            {{ __('Actualizar Técnico') }}
          </button>
        </div>

      </form>
    </div>
</x-app-layout>
