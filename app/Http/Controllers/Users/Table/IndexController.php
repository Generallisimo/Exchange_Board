<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data = $this->service->index();

        return view('pages.users.table.index', compact('data'));
    }
}
