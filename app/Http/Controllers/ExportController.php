<?php

namespace App\Http\Controllers;

use App\Exports\CdExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportToExcel()
    {
        $dateTimeNow = date('Ymd_His'); 
        $filename = 'data' . $dateTimeNow . '.xlsx';
        return Excel::download(new  CdExport, $filename);
    }
}
