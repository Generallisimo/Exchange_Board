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
        
        return view('pages.exchanges.index', compact('data'));
    }
}
