<?php

namespace App\Services\Users\Table\Market;

use App\Models\AddMarketDetails;
use App\Models\Market;

class MarketServices
{
    public function show($hash_id){

        $market_details = AddMarketDetails::where('hash_id', $hash_id)->get();
        $market = Market::where('hash_id', $hash_id)->first();

        return [
            'market_details'=>$market_details,
            'market'=>$market
        ];
    }

    public function edit($id){
        $market_details = AddMarketDetails::where('id', $id)->first();

        return [
            'market_details'=>$market_details,
        ];
    }

    public function update($hash_id){
        $status = Market::where('hash_id', $hash_id)->first();
        
        if($status->status === 'offline'){
            Market::where('hash_id', $hash_id)->update([
                'status'=> 'online',
            ]);
        }elseif($status->status === 'online'){
            Market::where('hash_id', $hash_id)->update([
                'status'=> 'offline',
            ]);
        }
    }
}