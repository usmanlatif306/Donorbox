<?php

namespace App\Http\Controllers;

use App\Exports\DonationsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DonationsExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->has('type') && $request->type === 'pdf') {
            $name = 'donations.pdf';
            $format = \Maatwebsite\Excel\Excel::DOMPDF;
        } else {
            $name = 'donations.xlsx';
            $format = \Maatwebsite\Excel\Excel::XLSX;
        }
        return Excel::download(new DonationsExport, $name, $format);
    }
}
