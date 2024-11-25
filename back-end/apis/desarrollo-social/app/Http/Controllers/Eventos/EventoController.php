<?php

namespace App\Http\Controllers\Eventos;

use App\Http\Controllers\Controller;
use App\Models\Eventos\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        return Evento::with('tipoEvento')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_evento_id' => 'required|exists:tipo_eventos,id',
            'direccion_id' => 'required|integer',
            'titulo' => 'required|string|max:50',
            'descripcion' => 'required|string|max:250',
            'ubicacion' => 'required|string|max:100',
            'fecha' => 'required|date',
            'hora_inicial' => 'required|string|max:20',
            'hora_final' => 'required|string|max:20',
            'responsable' => 'required|string|max:50',
        ]);

        $evento = Evento::create($validated);
        return response()->json($evento, 201);
    }

    public function show(Evento $evento)
    {
        return $evento->load('tipoEvento');
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'tipo_evento_id' => 'required|exists:tipo_eventos,id',
            'direccion_id' => 'required|integer',
            'titulo' => 'required|string|max:50',
            'descripcion' => 'required|string|max:250',
            'ubicacion' => 'required|string|max:100',
            'fecha' => 'required|date',
            'hora_inicial' => 'required|string|max:20',
            'hora_final' => 'required|string|max:20',
            'responsable' => 'required|string|max:50',
        ]);

        $evento->update($validated);
        return response()->json($evento);
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->json(null, 204);
    }
}
