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
        $result = $this->service->index($client_id, $amount, $currency);
        if($result['success']){
            return view('pages.Exchanges.index', compact('result'));
        }else{
            return view('pages.Exchanges.error.error_market');
        }
    }
}
