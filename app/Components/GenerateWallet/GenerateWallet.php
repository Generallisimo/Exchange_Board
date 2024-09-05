<?php

namespace App\Components\GenerateWallet;

use Illuminate\Support\Facades\Http;

class GenerateWallet{
    public function createWallet()
    {
        return Http::post('http://localhost:3000/create');
    }
}