<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * TAREA 2: Este método tiene funcionalidad incompleta.
     * Encontrá qué falta y completalo según las consignas.
     */
    public function index(Request $request)
    {
        $solicitudes = Solicitud::orderBy('created_at', 'desc')->get();

        return view('solicitudes.index', compact('solicitudes'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('solicitudes.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:100',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Solicitud::create([
            'user_id'      => auth()->id(),
            'categoria_id' => $request->categoria_id,
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'estado'       => 'pendiente',
        ]);

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

    public function show(Solicitud $solicitud)
    {
        return view('solicitudes.show', compact('solicitud'));
    }

    /**
     * TAREA 1: Este método tiene un bug.
     * El formulario de edición carga pero los campos aparecen vacíos.
     * Encontrá la causa y corregila
     */
    public function edit(Solicitud $solicitud)
    {
        $categorias = Categoria::all();

        return view('solicitudes.edit', compact('solicitud', 'categorias'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'titulo'       => 'required|string|max:100',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'estado'       => 'required|in:pendiente,en proceso,resuelto',
        ]);

        $solicitud->update($request->only('titulo', 'descripcion', 'categoria_id', 'estado'));

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud actualizada correctamente.');
    }

    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud eliminada.');
    }
}
