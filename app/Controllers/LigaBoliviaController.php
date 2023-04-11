<?php

namespace App\Controllers;

use View;

class LigaBoliviaController extends Controller
{
    /**
     * Verify if user is logged.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Auth');
    }
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('bolivia.liga');
    }
}
