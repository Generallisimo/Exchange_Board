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
     
        if($data['success']){
            return view('dashboard', compact('data'));
        }else{
            return redirect()->route('support.index');
        }
    }

    public function show($period, $hash_id){
        $data = $this->service->show($period, $hash_id);

        // Преобразуйте данные в массив, если это необходимо
        $dataArray = json_decode($data->getContent(), true);
    
        return response()->json([
            'labels' => $dataArray['labels'] ?? [],
            'values' => $dataArray['values'] ?? [],
        ]);
    }
}
