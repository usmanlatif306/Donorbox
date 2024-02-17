<?php

namespace App\Http\Controllers;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('plans.index');
    }
}
