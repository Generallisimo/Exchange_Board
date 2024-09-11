<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $this->service->index();

        return view('pages.transactions.index', compact('data'));
    }
}
