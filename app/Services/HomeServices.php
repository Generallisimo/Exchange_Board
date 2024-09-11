<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeServices
{
    public function index(){
        $userFind = Auth::user()->hash_id;
        $userId = User::where('hash_id', $userFind)->first();
        
        if($userId->hasRole('admin')){
            $user = Platform::where('hash_id', $userId->hash_id)->first();
            return ['user'=>$user];
        }elseif($userId->hasRole('agent')){
            $user = Agent::where('hash_id', $userId->hash_id)->first();
            return ['user'=>$user];
        }elseif($userId->hasRole('market')){
            $user = Market::where('hash_id', $userId->hash_id)->first();
            return ['user'=>$user];
        }elseif($userId->hasRole('client')){
            $user = Client::where('hash_id', $userId->hash_id)->first();
            return ['user'=>$user];
        }
    }
}