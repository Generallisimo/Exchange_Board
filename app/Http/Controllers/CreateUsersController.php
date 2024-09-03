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

            $this->sendTRX($data['address'], 'TLwBnPPSnqyze6Z5PFupUHMdpcknRghKrc', '6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e');
    

            if($user->hasRole('agent')){
            
                $agent = Agent::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'private_key'=>$data['privateKey'],
                ]);
                $checkBalanceAgent = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$agent->details_from,
                ]);
                $responseBalance = $checkBalanceAgent->json();
                $amountUpdateAgent = $responseBalance['balance'];
                $agent->balance = $amountUpdateAgent;
                $agent->save();
            }elseif($user->hasRole('market')){

                $market = Market::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'agent_id'=>$agent_id,
                    'private_key'=>$data['privateKey'],
                ]);

                $checkBalanceAgent = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$market->details_from,
                ]);
                $responseBalance = $checkBalanceAgent->json();
                $amountUpdateAgent = $responseBalance['balance'];
                $market->balance = $amountUpdateAgent;
                $market->save();
            }elseif($user->hasRole('client')){

                $link = url("api/payment/{$hash_id}");
                
                $client = Client::create([
                    'hash_id' => $hash_id,
                    'balance'=>'0',
                    'details_from'=>$data['address'],
                    'details_to'=>$details_to,
                    'percent'=>$percent,
                    'api_link'=>$link,
                    'private_key'=>$data['privateKey'],
                ]);

                $checkBalanceAgent = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$client->details_from,
                ]);
                $responseBalance = $checkBalanceAgent->json();
                $amountUpdateAgent = $responseBalance['balance'];
                $client->balance = $amountUpdateAgent;
                $client->save();
            }
            
            return redirect()->back()->with('successful', 'Users has been created!');
        }else{
            // добавить обработку
        };


    }

    private function sendTRX($addressTo, $ownerAddress, $privateKey){
        
        // $amountInSun = 100 * '1000000';

        Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('http://localhost:3000/sendTronTRX', [
            'addressTo' => $addressTo,
            'amount' => '100',
            'ownerAddress' => $ownerAddress,
            'privateKey' => $privateKey,
        ]);
    }

}
