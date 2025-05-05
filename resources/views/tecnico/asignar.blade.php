@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h1 class="text-2xl font-semibold mb-6">Asignar Medidor a Técnico: {{ $tecnico->nombre }} {{ $tecnico->apellido }}</h1>

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('tecnico.medidor.store', $tecnico) }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="medidor_id" class="block text-gray-700 mb-2">Medidor</label>
      <select name="medidor_id" id="medidor_id" class="w-full border border-gray-300 rounded px-3 py-2">
        <option value="">Selecciona un medidor</option>
        @foreach($medidores as $medidor)
          <option value="{{ $medidor->id }}" {{ old('medidor_id') == $medidor->id ? 'selected' : '' }}>
            {{ $medidor->codigo_medidor }} - Sector: {{ $medidor->sector->nombre }}
          </option>
        @endforeach
      </select>
      @error('medidor_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="valor" class="block text-gray-700 mb-2">Valor inicial del medidor</label>
      <input type="number" name="valor" id="valor" step="0.01" value="{{ old('valor') }}"
             class="w-full border border-gray-300 rounded px-3 py-2">
      @error('valor')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
      Asignar Medidor
    </button>
    <a href="{{ route('tecnico.index') }}" class="ml-4 text-gray-600 hover:underline">Volver</a>
  </form>
</div>
@endsection
