<?php

namespace App\Http\Controllers\Support;

use App\Events\Support\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $this->service->store();
        $message = Message::create([
            'name' => 'Anonymous', // Можно динамически передавать имя
            'messages' => $request->message,
        ]);

        broadcast(new SendMessage($message))->toOthers();

        return response()->json(['status' => 'Message sent successfully']);
    }
}
