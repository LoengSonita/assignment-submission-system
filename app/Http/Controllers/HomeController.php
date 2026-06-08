<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show welcome page for non-authenticated users.
     */
    public function welcome()
    {
        return view('welcome');
    }
}
