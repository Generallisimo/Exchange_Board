<?php

namespace App\Http\Controllers;

use App\Models\AddMarketDetails;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;

class UsersCheckController extends Controller
{
    public function index(){
        $clients = Client::all();
        $agents = Agent::all();
        $markets = Market::all();
        $users = User::all();

        return view('pages.all_users', compact('clients', 'agents', 'markets', 'users'));
    }

    public function deleteUser($hash_id){
        User::where('hash_id', $hash_id)->delete();

        return redirect()->back();
    }

    public function update ($hash_id){

        $userRole = User::where('hash_id', $hash_id)->first();

        if($userRole->hasRole('client')){
            
            $user = Client::where('hash_id', $hash_id)->first();

            return view('pages.update_users', compact('hash_id', 'user'));

        }elseif ($userRole->hasRole('agent')){
            
            $user = Agent::where('hash_id', $hash_id)->first();

            return view('pages.update_users', compact('hash_id', 'user'));

        }elseif($userRole->hasRole('market')){
            
            $user = Market::where('hash_id', $hash_id)->first();

            return view('pages.update_users', compact('hash_id', 'user'));

        }


    }

    public function updateUserStatus(Request $request, $hash_id){
        $status = Market::where('hash_id', $hash_id)->first();
        if($status->status === 'offline'){
            Market::where('hash_id', $hash_id)->update([
                'status'=> 'online',
            ]);
            return redirect()->back();
        }elseif($status->status === 'online'){
            Market::where('hash_id', $hash_id)->update([
                'status'=> 'offline',
            ]);
            return redirect()->back();
        }
    }
    public function updateUser(Request $request, $hash_id){
        
        $role = User::where('hash_id', $hash_id)->first();

        $details_from = $request->input('details_from');
        $details_to = $request->input('details_to');
        $balance = $request->input('balance');
        $percent = $request->input('percent');
        $private_key = $request->input('private_key');



        if($role->hasRole('client')){
            
            Client::where('hash_id', $hash_id)->update([
                'details_from'=> $details_from,
                'details_to'=> $details_to,
                'balance'=> $balance,
                'percent'=> $percent,
                'private_key'=> $private_key,
            ]);

        }elseif($role->hasRole('agent')){
            
            Agent::where('hash_id', $hash_id)->update([
                'details_from'=> $details_from,
                'details_to'=> $details_to,
                'balance'=> $balance,
                'percent'=> $percent,
                'private_key'=> $private_key,
            ]);

        }elseif($role->hasRole('market')){
            
            Market::where('hash_id', $hash_id)->update([
                'details_from'=> $details_from,
                'details_to'=> $details_to,
                'balance'=> $balance,
                'percent'=> $percent,
                'private_key'=> $private_key,
            ]);

        }

        return redirect()->route('check.users');

    }

    public function walletMarket($hash_id){
        $market_details = AddMarketDetails::where('hash_id', $hash_id)->get();
        $market = Market::where('hash_id', $hash_id)->first();
        return view('pages.wallets_market', compact('market_details', 'hash_id', 'market'));
    }
    
    public function wallet($id){
        $market_details = AddMarketDetails::where('id', $id)->first();
        return view('pages.change_wallet_market', compact('market_details'));
    }

    public function changeWalletMarkets(Request $request, $id){
        $details_to = $request->input('details_to');

        AddMarketDetails::where('id', $id)->update([
            'details_market_to'=>$details_to,
        ]);

        return redirect()->route('check.users');
    }

    public function changeStatus(Request $request){
        $status = $request->input('status');
        $details_to = $request->input('details_market_to');

        if($status === 'online'){
            AddMarketDetails::where('details_market_to', $details_to)->update([
                'online'=>'disabled',
            ]);
        }elseif($status === 'disabled'){
            AddMarketDetails::where('details_market_to', $details_to)->update([
                'online'=>'online',
            ]);
        }

        return redirect()->back();
        // $status = $request->input('status');
    }
}
