<?php

namespace App\Http\Controllers;

//use App\Models\Solicitud; Esto ya no es necesario usando $user->solicitudes() Elocuent ya sabe que modelo instanciar, no necesita importarlo

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * TAREA 4: Completá este método usando Eloquent.
     * Debe retornar a la vista 'reportes.resumen' con:
     *   - Total de solicitudes del usuario logueado
     *   - Cantidad de solicitudes agrupadas por estado
     *   - La solicitud más reciente del usuario (título, estado y fecha)
     *
     * No uses SQL crudo (DB::select / DB::statement).
     */
    public function resumen()
    {
        //Use los mismos nombres de variables de la view del blade para agilizar
        $user = auth()->user();
        $total = $user->solicitudes()->count();

        $porEstado = $user->solicitudes()
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->get();

        $ultima = $user->solicitudes()
            ->latest()
            ->first();

        return view('reportes.resumen', compact('total', 'porEstado', 'ultima'));
    }
}
