<?php

namespace App\Http\Controllers\API;

use App\Exports\WorkersExport;
use App\Http\Controllers\Controller;
use App\Imports\WorkersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function export()
    {
        return Excel::download(new WorkersExport, 'workers.xlsx');
    }

    public function import()
    {
        Excel::import(new WorkersImport, request()->file('excelFile'));

        return response()->json([
            'message' =>'All good!'
        ]);
    }
}
