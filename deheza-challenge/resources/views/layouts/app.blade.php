<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Solicitudes')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <span class="font-semibold text-gray-700">Sistema de Solicitudes</span>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('solicitudes.index') }}" class="text-gray-600 hover:text-gray-900">Mis solicitudes</a>
                <a href="{{ route('reporte.resumen') }}" class="text-gray-600 hover:text-gray-900">Resumen</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
