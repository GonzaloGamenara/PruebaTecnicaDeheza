<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
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
        return view('reportes.resumen');
    }
}
