<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $hash_id = $request->input('hash_id');
        $password = $request->input('password');
        $role = $request->input('role');
        $details_to = $request->input('details_to');
        $details_from = $request->input('details_from');
        $balance = $request->input('balance');
        $percent = $request->input('percent');
        $agent_id = $request->input('agent_id');
        $private_key = $request->input('private_key');

        $market_hash_id = Market::all()->random(1)->first();

        $user = User::create([
            'hash_id'=>$hash_id,
            'password'=>Hash::make($password),
        ]);

        $user->assignRole($role);

        switch ($role){
            case 'client':
                $link = url("api/payment/{$hash_id}/{$market_hash_id->hash_id}");
                Client::create([
                    'hash_id' => $hash_id,
                    'balance'=>$balance,
                    'details_to'=>$details_to,
                    'details_from'=>$details_from,
                    'percent'=>$percent,
                    'api_link'=>$link,
                    'private_key'=>$private_key,
                ]);
                break;

            case 'agent':
                Agent::create([
                    'hash_id' => $hash_id,
                    'balance'=>$balance,
                    'details_to'=>$details_to,
                    'details_from'=>$details_from,
                    'percent'=>$percent,
                    'private_key'=>$private_key,
                ]);
                break;
            
            case 'market':
                if(!$agent_id){
                    Market::create([
                        'hash_id' => $hash_id,
                        'balance'=>$balance,
                        'details_to'=>$details_to,
                        'details_from'=>$details_from,
                        'percent'=>$percent,
                        'private_key'=>$private_key,
                    ]);
                }else{
                    Market::create([
                        'hash_id' => $hash_id,
                        'balance'=>$balance,
                        'details_to'=>$details_to,
                        'details_from'=>$details_from,
                        'percent'=>$percent,
                        'agent_id'=>$agent_id,
                        'private_key'=>$private_key,
                    ]);
                }
                break;
        };

        return redirect()->back()->with('successful', 'Users has been created!');
    }

}
