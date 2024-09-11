<?php

namespace App\Components\checkBalance;

use App\Models\Agent;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckBalance{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->checkBalanceUser();

    }
    
    public function checkBalanceUser(){

        try{
            $currentBalance = $this->user->balance;

            $checkBalance = Http::get('http://localhost:3000/check_balance', [
                'ownerAddress'=>$this->user->details_from,
            ]);
            $responseBalance = $checkBalance->json();
            $amountUpdate = $responseBalance['balance'];
            
            if($currentBalance !== $amountUpdate){
                $this->user->balance = $amountUpdate;
                $this->user->save(); 
            }
            // add validate error
            return ['success'=> true];
           
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Ошибка соеденения'.$e->getMessage()
            ];
        }
    }
}