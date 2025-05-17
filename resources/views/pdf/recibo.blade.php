{{-- resources/views/pdf/recibo.blade.php --}}
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; }
    .header h1 { margin: 0; }
    .info, .totales { width: 100%; margin-bottom: 10px; }
    .info td, .totales td { padding: 4px; }
    .totales { border-top: 1px solid #000; font-weight: bold; }
  </style>
</head>
<body>
  <div class="header">
    <h1>RECIBO DE CONSUMO</h1>
    <p>{{ $consumo->cliente->manzana->ciudad->nombre }} - {{ \Carbon\Carbon::parse($consumo->fecha_emision)->format('F Y') }}</p>
  </div>

  <table class="info">
    <tr>
      <td><strong>Código suministro:</strong> {{ $consumo->cliente->code_suministro }}</td>
      <td><strong>Cliente:</strong> {{ $consumo->cliente->nombre }} {{ $consumo->cliente->apellido }}</td>
    </tr>
    <tr>
      <td><strong>DNI:</strong> {{ $consumo->cliente->dni }}</td>
      <td><strong>Dirección:</strong> {{ $consumo->cliente->direccion }}</td>
    </tr>
    <tr>
      <td><strong>Teléfono:</strong> {{ $consumo->cliente->telefono }}</td>
      <td><strong>Email:</strong> {{ $consumo->cliente->email }}</td>
    </tr>
  </table>

  <table class="info">
    <tr>
      <td><strong>Consumo (m³):</strong> {{ $consumo->m3_consumidos }}</td>
      <td><strong>Fecha emisión:</strong> {{ \Carbon\Carbon::parse($consumo->fecha_emision)->format('d/m/Y') }}</td>
      <td><strong>Fecha venc.: </strong> {{ \Carbon\Carbon::parse($consumo->fecha_vencimiento)->format('d/m/Y') }}</td>
    </tr>
  </table>

  <table class="totales">
    <tr>
      <td>Total a pagar:</td>
      <td style="text-align: right;">S/ {{ number_format($consumo->valor, 2) }}</td>
    </tr>
  </table>
</body>
</html>
