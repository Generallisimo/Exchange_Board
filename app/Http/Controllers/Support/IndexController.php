<?php

namespace App\Http\Controllers\Support;

use App\Events\Support\SendMessage;
use App\Models\Message;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // $this->service->index();
        // $data = Message::latest()->get();
        $data = Message::all();

        return view('pages.support.index', compact('data'));
    }
}
