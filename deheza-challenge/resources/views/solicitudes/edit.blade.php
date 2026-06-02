@extends('layouts.app')

@section('title', 'Editar Solicitud')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar solicitud</h1>

    <div class="bg-white rounded shadow p-6">
        <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $solicitud->titulo) }}"
                    class="w-full border rounded px-3 py-2 text-sm @error('titulo') border-red-400 @enderror">
                @error('titulo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                    class="w-full border rounded px-3 py-2 text-sm @error('descripcion') border-red-400 @enderror">{{ old('descripcion', $solicitud->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select name="categoria_id"
                    class="w-full border rounded px-3 py-2 text-sm @error('categoria_id') border-red-400 @enderror">
                    <option value="">-- Seleccioná una categoría --</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id', $solicitud->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado"
                    class="w-full border rounded px-3 py-2 text-sm @error('estado') border-red-400 @enderror">
                    @foreach(['pendiente', 'en proceso', 'resuelto'] as $estado)
                        <option value="{{ $estado }}"
                            {{ old('estado', $solicitud->estado) === $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado) }}
                        </option>
                    @endforeach
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm">
                    Actualizar
                </button>
                <a href="{{ route('solicitudes.index') }}"
                    class="text-gray-500 px-5 py-2 rounded hover:text-gray-700 text-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
