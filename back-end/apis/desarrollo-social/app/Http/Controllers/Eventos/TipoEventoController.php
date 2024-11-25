<?php

namespace App\Http\Controllers\Eventos;

use App\Http\Controllers\Controller;
use App\Models\Eventos\TipoEvento;

use Illuminate\Http\Request;
    
class TipoEventoController extends Controller
{
    public function index()
    {
        return TipoEvento::all();
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'descripcion' => 'required|string|max:20',
        ]);
  
        try {
            $tipoEvento = TipoEvento::create($validated);
            return response($tipoEvento, 201);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
  
    }

    public function show(TipoEvento $tipoEvento)
    {
        return $tipoEvento;
    }

    public function update(Request $request, TipoEvento $tipoEvento)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:20',
        ]);

        $tipoEvento->update($validated);
        return response()->json($tipoEvento);
    }

    public function destroy(TipoEvento $tipoEvento)
    {
        $tipoEvento->delete();
        return response()->json(null, 204);
    }

}
