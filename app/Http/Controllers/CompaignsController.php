<?php

namespace App\Http\Controllers;

class CompaignsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('compaigns.index');
    }
}
