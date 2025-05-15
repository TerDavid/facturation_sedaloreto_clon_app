{{-- resources/views/layouts/navigation.blade.php --}}
<aside
  x-data="{
    // Inicializa desde localStorage o, si no existe, true (abierto)
    sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true')
  }"
  x-init="
    // Observa cambios y guarda en localStorage
    $watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', JSON.stringify(value)))
  "
  :class="sidebarOpen ? 'w-64' : 'w-16'"
  class="sticky top-0 left-0 h-screen transition-all duration-300 bg-blue-600 shadow overflow-hidden"
>
  <nav class="mt-4 flex flex-col space-y-2 font-medium">
    {{-- Toggle --}}
    <button
      @click="sidebarOpen = !sidebarOpen"
      class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
      :class="!sidebarOpen && 'justify-center px-2'"
      title="Toggle sidebar"
    >
      <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg"
           class="w-6 h-6 text-white group-hover:text-black" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12"/>
      </svg>
      <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg"
           class="w-6 h-6 text-white group-hover:text-black" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">

      </span>
    </button>

    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}"
       class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
       :class="!sidebarOpen && 'justify-center px-2'"
    >
      <svg class="w-6 h-6 text-white group-hover:text-black" fill="currentColor" viewBox="0 0 22 21">
        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd" />
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
        Dashboard
      </span>
    </a>

    {{-- Clientes --}}
    <a href="{{ route('gestion_clientes.index') }}"
       class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
       :class="!sidebarOpen && 'justify-center px-2'"
    >
      <svg class="w-6 h-6 text-white group-hover:text-black" fill="currentColor" viewBox="0 0 22 21">
        <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
        Clientes
      </span>
    </a>

    {{-- Facturación --}}
    <a href="{{ route('sede.index') }}"
       class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
       :class="!sidebarOpen && 'justify-center px-2'"
    >
      <svg class="w-6 h-6 text-white group-hover:text-black" fill="currentColor" viewBox="0 0 22 21">
        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
        Facturación
      </span>
    </a>
    {{-- Mantenimiento --}}
    <a href="{{ route('sede.index') }}"
       class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
       :class="!sidebarOpen && 'justify-center px-2'"
    >
      <svg class="w-6 h-6 text-white group-hover:text-black" fill="currentColor" viewBox="0 0 22 21">
        <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
        Mantenimiento
      </span>
    </a>

    {{-- Perfil --}}
    <a href="{{ route('profile.edit') }}"
       class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
       :class="!sidebarOpen && 'justify-center px-2'"
    >
      <svg class="w-6 h-6 text-white group-hover:text-black" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 2a4 4 0 100 8 4 4 0 000-8z"/>
        <path fill-rule="evenodd" d="M.458 18a8 8 0 0115.084 0A9.718 9.718 0 0110 20c-2.577 0-4.924-.784-6.542-2.058z" clip-rule="evenodd"/>
      </svg>
      <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
        Perfil
      </span>
    </a>

    {{-- Cerrar sesión --}}
    <form
      method="POST"
      action="{{ route('logout') }}"
      class="group flex items-center justify-start px-4 py-2 hover:bg-gray-100"
      :class="!sidebarOpen && 'justify-center px-2'"
    >
      @csrf
      <button type="submit" class="flex items-center">
        <svg class="w-6 h-6 text-white group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7"/>
        </svg>
        <span x-show="sidebarOpen" class="ml-3 text-white group-hover:text-black whitespace-nowrap">
          Cerrar sesión
        </span>
      </button>
    </form>
  </nav>
</aside>
