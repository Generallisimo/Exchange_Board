<?php

namespace App\Http\Controllers\Users\Table\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        $data = $this->service->show($hash_id);
        
        return view('pages.users.table.market.show', compact('data', 'hash_id'));
    }
}
