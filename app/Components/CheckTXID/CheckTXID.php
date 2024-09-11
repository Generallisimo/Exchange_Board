<?php

namespace App\Components\CheckTXID;

use Illuminate\Support\Facades\Http;

class CheckTXID
{
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function check(){
        $url = 'http://localhost:3000/check_txid';
        
        $response = Http::post($url, [
            'transactionHash'=>$this->transaction
        ]);
        $data = $response->json();

        if($data['success'] === true){
            return ['success'=>true];
        }else{
            return ['success'=>false];
        }
    }
}