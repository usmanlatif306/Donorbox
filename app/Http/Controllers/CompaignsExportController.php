<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CompaignExport;
use Maatwebsite\Excel\Facades\Excel;

class CompaignsExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->has('type') && $request->type === 'pdf') {
            $name = 'compaigns.pdf';
            $format = \Maatwebsite\Excel\Excel::DOMPDF;
        } else {
            $name = 'compaigns.xlsx';
            $format = \Maatwebsite\Excel\Excel::XLSX;
        }
        return Excel::download(new CompaignExport, $name, $format);
    }
}
