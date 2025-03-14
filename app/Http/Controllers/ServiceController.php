<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.service.index', [
            'title' => 'Service Kami',
            'services' => Service::latest()->paginate(6)
        ]);
    }
}
