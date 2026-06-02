@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mis solicitudes</h1>
    <a href="{{ route('solicitudes.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        + Nueva solicitud
    </a>
</div>

{{--
    TAREA 2 y 3: Agregar aquí el formulario de filtro por estado.
    Ejemplo de estructura sugerida (completar la lógica):

    <form method="GET" action="{{ route('solicitudes.index') }}" class="mb-4">
        <select name="estado" ...>
            ...
        </select>
        <button type="submit">Filtrar</button>
    </form>
--}}

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Título</th>
                <th class="px-4 py-3 text-left">Categoría</th>
                <th class="px-4 py-3 text-left">Estado</th>
                <th class="px-4 py-3 text-left">Fecha</th>
                <th class="px-4 py-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($solicitudes as $solicitud)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800">{{ $solicitud->titulo }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $solicitud->categoria->nombre }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-medium 
                        @if($solicitud->estado === 'pendiente') bg-yellow-100 text-yellow-800 
                        @elseif($solicitud->estado === 'en proceso') bg-blue-100 text-blue-800 
                        @else bg-green-100 text-green-800 
                        @endif">
                        {{ ucfirst($solicitud->estado) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $solicitud->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('solicitudes.edit', $solicitud) }}"
                       class="text-blue-600 hover:underline">Editar</a>
                    <form method="POST" action="{{ route('solicitudes.destroy', $solicitud) }}"
                          onsubmit="return confirm('¿Confirmás la eliminación?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                    Todavía no registraste ninguna solicitud.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TAREA 2: Agregar aquí el mensaje cuando no hay solicitudes --}}

</div>
@endsection
