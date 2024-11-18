<?php

namespace App\Http\Controllers\Personas;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeneficiarioUnicoResource;
use App\Models\Muni\TbBeneficiarioUnico;
use App\Rules\ValidateCui;
use Illuminate\Http\Request;

class HistorialBeneficiarioUnicoController extends Controller
{
    public function index() {
        
    }

    public function show(Request $request) {
        $request->validate([
            'cui' => ['required','numeric','digits:13',new ValidateCui],
        ]);

        try {
            
            $beneficiarioUnico = TbBeneficiarioUnico::where('cui',$request->cui)->firstOrFail();
        
            return response(BeneficiarioUnicoResource::make($beneficiarioUnico));

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
