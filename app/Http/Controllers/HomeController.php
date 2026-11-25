<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'title' => 'NekoMang',
            'description' => 'Информационная система для чтения манги',
        ]);
    }
}
