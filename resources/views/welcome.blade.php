{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-bold text-4xl text-black leading-tight">
        {{ __('Dashboard') }}
      </h2>
    </x-slot>

    <div class="py-[5vh] px-[5vw] space-y-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        {{-- Card 1: Volumen por ciudad --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="font-semibold text-lg mb-4">Volumen Total (m³) por Ciudad</h3>
          <canvas id="chartVolumen"></canvas>
        </div>

        {{-- Card 2: Valor por cliente --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="font-semibold text-lg mb-4">Top 10 Clientes por Valor (S/)</h3>
          <canvas id="chartValor"></canvas>
        </div>

        {{-- ... puedes seguir añadiendo más cards ... --}}

      </div>
    </div>

    {{-- Chart.js desde CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        // Datos PHP pasados a JS
        const volumenLabels = @json($volumenPorCiudad->pluck('nombre'));
        const volumenData   = @json($volumenPorCiudad->pluck('total_m3'));

        new Chart(document.getElementById('chartVolumen').getContext('2d'), {
          type: 'bar',
          data: {
            labels: volumenLabels,
            datasets: [{
              label: 'm³',
              data: volumenData,
              backgroundColor: 'rgba(29, 78, 216, 0.5)',
              borderColor: 'rgba(29, 78, 216, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: { y: { beginAtZero:true } }
          }
        });

        const valorLabels = @json($valorPorCliente->pluck('cliente'));
        const valorData   = @json($valorPorCliente->pluck('total_valor'));

        new Chart(document.getElementById('chartValor').getContext('2d'), {
          type: 'horizontalBar',
          data: {
            labels: valorLabels,
            datasets: [{
              label: 'S/',
              data: valorData,
              backgroundColor: 'rgba(16, 185, 129, 0.5)',
              borderColor: 'rgba(16, 185, 129, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              x: { beginAtZero:true }
            },
            indexAxis: 'y'
          }
        });
      });
    </script>
  </x-app-layout>
