<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUsersController extends Controller
{
    public function index(Request $request){
        $hash_id = Str::random(12);
        $agents = Agent::all();
        // dd($agents);
        return view('pages.create_users', compact('hash_id', 'agents'));
    }

    public function registerNewUser(Request $request){
        $hash_id = $request->input('hash_id');
        $password = $request->input('hash_id');
        $role = $request->input('role');
        $details_to = $request->input('details_to');
        $details_from = $request->input('details_from');
        $balance = $request->input('balance');
        $percent = $request->input('percent');
        $agent_id = $request->input('agent_id');

        // dd($request->input('hash_id'));
        // dd($request->all());

        $user = User::create([
            'hash_id'=>$hash_id,
            'password'=>Hash::make($password),
        ]);

        $user->assignRole($role);

        switch ($role){
            case 'client':
                Client::create([
                    'hash_id' => $hash_id,
                    'balance'=>$balance,
                    'details_to'=>$details_to,
                    'details_from'=>$details_from,
                    'percent'=>$percent,
                ]);
                break;

            case 'agent':
                Agent::create([
                    'hash_id' => $hash_id,
                    'balance'=>$balance,
                    'details_to'=>$details_to,
                    'details_from'=>$details_from,
                    'percent'=>$percent,
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
                    ]);
                }else{
                    Market::create([
                        'hash_id' => $hash_id,
                        'balance'=>$balance,
                        'details_to'=>$details_to,
                        'details_from'=>$details_from,
                        'percent'=>$percent,
                        'agent_id'=>$agent_id,
                    ]);
                }
                break;
        };

        return redirect()->back()->with('successful', 'Users has been created!');
    }

}
