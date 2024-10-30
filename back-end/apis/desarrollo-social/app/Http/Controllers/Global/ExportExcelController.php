<?php

namespace App\Http\Controllers\Global;

use App\Exports\DataExportGeneric;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function exportExcel(Request $request) {
        $request->validate([
            'columns' => 'required',
            'data' => 'required',
        ]);

        try {
            
            return Excel::download(new DataExportGeneric($request->columns,$request->data),'export.xlsx');

        } catch (\Throwable $th) {
            
            return response($th->getMessage());
        }
    }
}