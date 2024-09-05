<?php

namespace App\Services\Users;

use App\Http\Requests\Users\Detials\StoreRequest;
use App\Models\AddMarketDetails;
use App\Models\Market;
use App\Models\MethodPayments;

class NewDetailsService
{
    public function create(){
        $markets = Market::all();
        $methods = MethodPayments::all();
        
        return [
            'markets'=>$markets,
            'methods'=>$methods,
        ];
    }

    public function store(array $data_request){
        
        $currencyMethod = MethodPayments::where('name_method', $data_request['name_method'])->first();
        $currency = $currencyMethod->currency;

        $result = $this->newDetails(
            $data_request['hash_id'], 
            $data_request['details_market_to'], 
            $data_request['name_method'],
            $currency,
            $data_request['comment']
        );
    
        if($result === true){
            return true;
        }else{
            return "Ошибка добавления карты обратитесь в поддержку";
        }
       
    }

    protected function newDetails($hash_id, $details_to, $name_method, $currency, $comment){

        $newDetail = AddMarketDetails::create([
            'hash_id' => $hash_id,
            'details_market_to' => $details_to,
            'name_method' => $name_method,
            'currency' => $currency,
            'comment' => $comment,
        ]);

        return $newDetail ? true : false;
    }
}