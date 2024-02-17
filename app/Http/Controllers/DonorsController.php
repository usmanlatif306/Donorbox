<?php

namespace App\Http\Controllers;

class DonorsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('donors.index');
    }
}
