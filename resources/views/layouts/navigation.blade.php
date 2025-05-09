{{-- resources/views/layouts/navigation.blade.php --}}
<aside
  x-data="{ sidebarOpen: true }"
  :class="sidebarOpen ? 'w-64' : 'w-16'"
  class="sticky top-0 left-0 h-screen transition-all duration-300 bg-cyan-500 shadow overflow-hidden"
>
  <nav class="mt-4 flex flex-col space-y-2 font-medium">
    {{-- Toggle --}}
    <button
      @click="sidebarOpen = !sidebarOpen"
      :class="sidebarOpen
        ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
        : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
     
    >
      <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg"
           class="w-6 h-6 text-gray-600" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12"/>
      </svg>
      <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg"
           class="w-6 h-6 text-gray-600" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Cerrar
      </span>
    </button>

    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}"
       :class="sidebarOpen
         ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
         : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 22 21">
        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Dashboard
      </span>
    </a>

    {{-- Clientes --}}
    <a href="{{ route('clientes.index') }}"
       :class="sidebarOpen
         ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
         : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 22 21">
        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Clientes
      </span>
    </a>

    {{-- Facturación --}}
    <a href="{{ route('sede.index') }}"
       :class="sidebarOpen
         ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
         : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 22 21">
        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Facturación
      </span>
    </a>

    {{-- Mantenimiento --}}
    <a href="{{ route('sede.index') }}"
       :class="sidebarOpen
         ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
         : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 22 21">
        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Mantenimiento
      </span>
    </a>

    {{-- Perfil --}}
    <a href="{{ route('profile.edit') }}"
       :class="sidebarOpen
         ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
         : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 2a4 4 0 100 8 4 4 0 000-8z"/>
        <path fill-rule="evenodd"
              d="M.458 18a8 8 0 0115.084 0A9.718 9.718 0 0110 20c-2.577 0-4.924-.784-6.542-2.058z"
              clip-rule="evenodd"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
        Perfil
      </span>
    </a>

    {{-- Cerrar sesión --}}
    <form
      method="POST"
      action="{{ route('logout') }}"
      :class="sidebarOpen
        ? 'flex items-center justify-start px-4 py-2 hover:bg-gray-100'
        : 'flex items-center justify-center px-2 py-2 hover:bg-gray-100'"
    >
      @csrf
      <button type="submit" class="flex items-center">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7"/>
        </svg>
        <span x-show="sidebarOpen" class="ml-3 text-gray-900 whitespace-nowrap">
          Cerrar sesión
        </span>
      </button>
    </form>
  </nav>
</aside>
