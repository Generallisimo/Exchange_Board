<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($client_id, $amount, $currency)
    {
        $data = $this->service->index($client_id, $amount, $currency);
        if($data['success']){
            return view('pages.exchanges.index', compact('data'));
        }else{
            return view('pages.exchanges.error.error_market');
        }
    }
}
