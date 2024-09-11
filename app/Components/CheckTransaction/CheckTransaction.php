<?php

namespace App\Components\CheckTransaction;

use Exception;
use Illuminate\Support\Facades\Http;
use Mockery\Expectation;

class CheckTransaction 
{
    public $wallet;

    public function __construct($wallet)
    {
        $this->wallet = $wallet;   
        
        $this->check(); 
    }

    public function check(){
        try{
    
            $response = Http::get('http://localhost:3000/check_transaction', [
                'address' => $this->wallet,
                'hours'=> '1',
            ]);

            if($response->successful()){
                return [
                    'success'=>true,
                    'message'=>$response->json()
                ];  
            }else {
                return [
                    'success' => false,
                    'message' => 'Обрабатывается транзакция'
                ];
            }
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Ошибка соеденения'.$e->getMessage()
            ];
        }
    }
}