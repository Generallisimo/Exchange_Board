<?php

namespace App\Services\Withdrawals;

use App\Components\WithdrawalTRON\WithdrawalTRON;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WithdrawalServices
{
    public function index(){
        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        $user = $this->user($role, $hash_id);
        return ['user'=>$user];
    }

    public function update(array $data_request){

        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        
        $userID = $this->user($role, $hash_id);

        $result = (new WithdrawalTRON(
            $data_request['you_send'],
            $data_request['you_send_details'],
            $userID->details_from,
            $userID->private_key,
            $data_request['hash_id']
        ))->store();

        return $result['success'] ? true : $result['message'];
    }

    protected function user($role, $hash_id){
        if($role->hasRole('admin')){
            return Platform::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('client')){
            return Client::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('market')){
            return Market::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('agent')){
            return Agent::where('hash_id', $hash_id)->first();
        }
    }
}