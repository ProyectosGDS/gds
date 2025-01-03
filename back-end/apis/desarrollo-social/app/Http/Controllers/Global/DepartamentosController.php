<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Gds\Departamentos;
use App\Models\Gds\Paises;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departamentos = Departamentos::all();
            return response($departamentos);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamentos $departamento)
    {
        try {
            return response($departamento->load('municipios'));
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
