{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-bold text-4xl text-black leading-tight">
        {{ __('Dashboard') }}
      </h2>
    </x-slot>

    <div class="py-4 px-6">
      {{-- Filtro de fecha --}}
      <form method="GET" action="{{ route('dashboard') }}" class="flex space-x-2 mb-6">
        <div>
          <label class="block text-sm">Desde</label>
          <input type="date" name="start_date"
                 value="{{ old('start_date', $start) }}"
                 class="border rounded px-2 py-1"/>
        </div>
        <div>
          <label class="block text-sm">Hasta</label>
          <input type="date" name="end_date"
                 value="{{ old('end_date', $end) }}"
                 class="border rounded px-2 py-1"/>
        </div>
        <div class="self-end">
          <button type="submit"
                  class="bg-blue-600 text-white px-4 py-2 rounded">
            Filtrar
          </button>
        </div>
      </form>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        {{-- Gráfica 1: Volumen total --}}
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="font-semibold text-lg mb-3">
            Volumen Total (m³) por Ciudad
          </h3>
          <canvas id="chartVolumen"></canvas>
        </div>

        {{-- Gráfica 2: Evolución mensual (Barras agrupadas) --}}
        <div class="bg-white shadow-sm rounded-lg p-6 sm:col-span-2">
          <h3 class="font-semibold text-lg mb-3">
            Evolución Mensual de Valor Facturado por Ciudad
          </h3>
          <canvas id="chartSerieValor"></canvas>
        </div>

        {{-- Gráfica 3: Clientes activos --}}
        <div class="bg-white shadow-sm rounded-lg p-6 sm:col-span-2">
          <h3 class="font-semibold text-lg mb-3">
            Número de Clientes con Facturas en el Rango por Ciudad
          </h3>
          <canvas id="chartClientes"></canvas>
        </div>

      </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const palette = [
          'rgba(255,99,132,0.5)','rgba(54,162,235,0.5)',
          'rgba(255,206,86,0.5)','rgba(75,192,192,0.5)',
          'rgba(153,102,255,0.5)','rgba(255,159,64,0.5)'
        ];

        // — Gráfico 1: Volumen por ciudad —
        new Chart(
          document.getElementById('chartVolumen').getContext('2d'), {
          type: 'bar',
          data: {
            labels: @json($volumenPorCiudad->pluck('nombre')),
            datasets: [{
              label: 'm³',
              data: @json($volumenPorCiudad->pluck('total_m3')),
              backgroundColor: 'rgba(29,78,216,0.5)',
              borderColor: 'rgba(29,78,216,1)',
              borderWidth: 1
            }]
          },
          options: { scales:{ y:{ beginAtZero:true } } }
        });

        // — Gráfico 2: Evolución mensual (barras agrupadas) —
        const meses      = @json($meses);
        const ciuds      = @json($ciudades);
        const seriesData = @json($serieValorPorCiudad);

        new Chart(
          document.getElementById('chartSerieValor').getContext('2d'), {
          type: 'bar',
          data: {
            labels: meses,
            datasets: ciuds.map((ciudad, i) => ({
              label: ciudad,
              data: seriesData[ciudad],
              backgroundColor: palette[i % palette.length],
              borderColor: palette[i % palette.length].replace('0.5','1'),
              borderWidth: 1
            }))
          },
          options: {
            scales: {
              x: {
                stacked: false,
                title: { display: true, text: 'Mes (YYYY-MM)' }
              },
              y: {
                beginAtZero: true,
                title: { display: true, text: 'S/ Facturado' }
              }
            },
            plugins: {
              tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'nearest', axis: 'x', intersect: false }
          }
        });

        // — Gráfico 3: Clientes activos por ciudad —
        const ccL = @json($clientesPorCiudad->pluck('ciudad'));
        const ccD = @json($clientesPorCiudad->pluck('total_clientes'));

        new Chart(
          document.getElementById('chartClientes').getContext('2d'), {
          type: 'bar',
          data: {
            labels: ccL,
            datasets: [{
              label: 'Clientes',
              data: ccD,
              backgroundColor: ccL.map((_,i)=> palette[i % palette.length]),
              borderColor:      ccL.map((_,i)=> palette[i % palette.length].replace('0.5','1')),
              borderWidth: 1
            }]
          },
          options: {
            scales: { y: { beginAtZero: true, precision: 0 } },
            plugins: {
              legend: { display: false },
              tooltip: { callbacks: { label: ctx => `Clientes: ${ctx.parsed.y}` } }
            }
          }
        });
      });
    </script>
  </x-app-layout>
