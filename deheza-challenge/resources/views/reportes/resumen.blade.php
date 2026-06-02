@extends('layouts.app')

@section('title', 'Resumen')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Mi resumen</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

    {{-- Total de solicitudes --}}
    <div class="bg-white rounded shadow p-5 text-center">
        <p class="text-sm text-gray-500 mb-1">Total de solicitudes</p>
        <p class="text-3xl font-bold text-gray-800">
            {{ $total ?? '—' }}
        </p>
    </div>

    {{-- Por estado --}}
    <div class="bg-white rounded shadow p-5 md:col-span-2">
        <p class="text-sm text-gray-500 mb-3">Por estado</p>
        @if(isset($porEstado) && $porEstado->count())
            <div class="flex gap-4 flex-wrap">
                @foreach($porEstado as $item)
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800">{{ $item->total }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($item->estado) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-sm">Sin datos disponibles.</p>
        @endif
    </div>

</div>

{{-- Solicitud más reciente --}}
<div class="bg-white rounded shadow p-5">
    <p class="text-sm text-gray-500 mb-3">Solicitud más reciente</p>
    @if(isset($ultima) && $ultima)
        <div>
            <p class="font-medium text-gray-800">{{ $ultima->titulo }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Estado: <span class="font-medium">{{ ucfirst($ultima->estado) }}</span>
                &nbsp;·&nbsp;
                {{ $ultima->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    @else
        <p class="text-gray-400 text-sm">Sin solicitudes registradas todavía.</p>
    @endif
</div>
@endsection
