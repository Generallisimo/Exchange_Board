<?php

namespace App\Components\checkBalance;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckBalanceAgent{

    public $user;

    public function __construct(Agent $user)
    {
        $this->user = $user;
        $this->checkBalanceUser();

    }
    
    public function checkBalanceUser(){

        $checkBalanceAgent = Http::get('http://localhost:3000/check_balance', [
            'ownerAddress'=>$this->user->details_from,
        ]);
        $responseBalance = $checkBalanceAgent->json();
        $amountUpdateAgent = $responseBalance['balance'];
        $this->user->balance = $amountUpdateAgent;
        $this->user->save();
    }
}