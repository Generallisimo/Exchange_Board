<?php

namespace App\Components\SendToUserTRX;

use Illuminate\Support\Facades\Http;

class SendTRX
{
    public $addressTo;
    public $ownerAddress;
    public $privateKey;

    public function __construct($addressTo)
    {
        $this->addressTo = $addressTo;
        $this->ownerAddress = config('wallet.wallet');
        $this->privateKey = config('wallet.private_key');
    }
    
    public function sendTRX(){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://localhost:3000/sendTronTRX', [
            'addressTo' => $this->addressTo,
            'amount' => '100',
            'ownerAddress' => $this->ownerAddress,
            'privateKey' => $this->privateKey,
        ]);

        if ($response->successful()) {
            return true;
        } else {
            return $response->body();
        }
    }
}