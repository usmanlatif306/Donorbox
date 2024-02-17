<?php

namespace App\Http\Controllers;


class DonationsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('donations.index');
    }
}
