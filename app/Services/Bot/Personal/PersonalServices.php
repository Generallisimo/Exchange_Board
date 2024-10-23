<?php

namespace App\Services\Bot\Personal;

use App\Models\AddMarketDetails;
use App\Models\Market;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PersonalServices
{
    public function index($hash_id){
        $market = Market::where('hash_id', $hash_id)->first();
        $details_market = AddMarketDetails::where('hash_id', $hash_id)->get();
        // dd($market, $details_market);
        // dd($market);
        if($market){
            return [
                'success'=>true,
                'data'=> $market,
                'details'=>$details_market
            ];
        }else{
            return [
                'success'=>false
            ];
        }
    }


    public function update($hash_id){
        // dd($data);
        $status = Market::where('hash_id', $hash_id)->first();
        if ($status) {
            if ($status->status === 'offline') {
                Market::where('hash_id', $hash_id)->update(['status' => 'online']);
            } elseif ($status->status === 'online') {
                Market::where('hash_id', $hash_id)->update(['status' => 'offline']);
            }
            return ['success' => true];
        }
    
        return ['success' => false];
    }

    public function updateWallet(array $data){
        $user = $this->userDetails($data['hash_id'], $data['details_to']);
        // Log::info($data['details_to']);
        return $user? true: false;
    }

    protected function userDetails($hash_id, $details_to){
        $userId = User::where('hash_id', $hash_id)->first();

        if(!$userId){
            return false;
        }

        if($userId->hasRole('admin')){
            $user = Platform::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]);
        }elseif($userId->hasRole('agent')){
            $user = Agent::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }elseif($userId->hasRole('market')){
            $user = Market::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }elseif($userId->hasRole('client')){
            $user = Client::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }

        return $user? true : false;
    }
}