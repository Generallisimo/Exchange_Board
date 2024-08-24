<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUsersController extends Controller
{
    public function index(Request $request){
        $hash_id = Str::random(12);
        $agents = Agent::all();

        return view('pages.create_users', compact('hash_id', 'agents'));
    }

    public function registerNewUser(Request $request){

        $generate_data = Http::post('http://localhost:3000/create');

        if ($generate_data->successful()){
            $data = $generate_data->json();

            $hash_id = $request->input('hash_id');
            $password = $request->input('password');
            $role = $request->input('role');
            $details_to = $request->input('details_to');
            $percent = $request->input('percent');
            $agent_id = $request->input('agent_id');
            
            $user = User::create([
                'hash_id'=>$hash_id,
                'password'=>Hash::make($password),
            ]);
    
            $user->assignRole($role);
    

            if($user->hasRole('agent')){
                Agent::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'private_key'=>$data['privateKey'],
                ]);
            }elseif($user->hasRole('market')){
                Market::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'agent_id'=>$agent_id,
                    'private_key'=>$data['privateKey'],
                ]);
            }elseif($user->hasRole('client')){
                $market_hash_id = Market::all()->random(1)->first();
                $link = url("api/payment/{$hash_id}/{$market_hash_id->hash_id}");
                Client::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'api_link'=>$link,
                    'private_key'=>$data['privateKey'],
                ]);
            }
            
            return redirect()->back()->with('successful', 'Users has been created!');
        }else{
            // добавить обработку
        };


    }

}
