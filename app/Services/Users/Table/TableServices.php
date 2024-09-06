<?php

namespace App\Services\Users\Table;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;

class TableServices
{
    public function index(){
        $clients = Client::all();
        $agents = Agent::all();
        $markets = Market::all();
        $users = User::all();

        return [
            'clients'=>$clients,
            'agents'=>$agents,
            'markets'=>$markets,
            'users'=>$users,
        ];

    }

    public function edit($hash_id){

        $userRole = User::where('hash_id', $hash_id)->first();

        if($userRole->hasRole('client')){
            $user = Client::where('hash_id', $hash_id)->first();
        }elseif ($userRole->hasRole('agent')){
            $user = Agent::where('hash_id', $hash_id)->first();
        }elseif($userRole->hasRole('market')){
            $user = Market::where('hash_id', $hash_id)->first();
        }

        return $user;
    }

    public function update($hash_id, array $data_request){

        $role = User::where('hash_id', $hash_id)->first();

        if($role->hasRole('client')){
            
            Client::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

        }elseif($role->hasRole('agent')){
            
            Agent::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

        }elseif($role->hasRole('market')){
            
            Market::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

        }

    }
}