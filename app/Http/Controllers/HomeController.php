<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home.index', [
            'title' => 'Selamat Datang',
            'services' => Service::latest()->limit(6)->get()
        ]);
    }
}
