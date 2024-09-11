<?php

namespace App\Http\Controllers;

use App\Services\HomeServices;

class HomeController extends Controller
{
    public $service;

    public function __construct(HomeServices $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->service->index();
        return view('dashboard', compact('data'));
    }
}
