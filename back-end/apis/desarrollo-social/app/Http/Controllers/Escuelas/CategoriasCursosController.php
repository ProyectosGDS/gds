<?php

namespace App\Http\Controllers\Escuelas;

use App\Http\Controllers\Controller;
use App\Models\Gds\EscCategoriaCursos;
use Illuminate\Http\Request;

class CategoriasCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {    
        try {
            $categorias = EscCategoriaCursos::all();
            return response($categorias);

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
