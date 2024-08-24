<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WithdrawalController extends Controller
{
    public function index(){

        
        $userAuth = Auth::user()->hash_id;
        $userCheck = User::where('hash_id', $userAuth)->first();
        
        if($userCheck->hasRole('admin')){
            $user = Platform::where('hash_id', $userAuth)->first();;
            // $checkBalance = Http::get('http://localhost:3000/check_balance', [
            //     'ownerAddress'=>$user->details_from,
            // ]);
            // $responseBalance = $checkBalance->json();
            // $amountUpdate = $responseBalance['balance'];
            return view('pages.withdrawal', compact('user'));
        }elseif($userCheck->hasRole('market')){
            $user = Market::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }elseif($userCheck->hasRole('agent')){
            $user = Agent::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }elseif($userCheck->hasRole('client')){
            $user = Client::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }

    }


    public function withdrawal(Request $request){
        $hash_id = $request->input('hash_id');
        $details = $request->input('you_send_details');
        $amount = $request->input('you_send');
        // $currency = $request->input('currency_coin');

        $user = Auth::user()->hash_id;
        $role = User::where('hash_id', $user)->first();
        if($role->hasRole('admin')){
            $userID = Platform::where('hash_id', $user)->first();
            // dd($userID->details_from, $userID->private_key);
            $this->sendTronTrxToUsdt($amount, $details, $userID->details_from, $userID->private_key, $hash_id);
            return redirect()->back();
        }elseif($role->hasRole('client')){
            $userID = Client::where('hash_id', $user)->first();
            $this->sendTronTrxToUsdt($amount, $details, $userID->details_from, $userID->private_key, $hash_id);
            return redirect()->back();
        }elseif($role->hasRole('market')){
            $userID = Market::where('hash_id', $user)->first();
            $this->sendTronTrxToUsdt($amount, $details, $userID->details_from, $userID->private_key, $hash_id);
            return redirect()->back();
        }elseif($role->hasRole('agent')){
            $userID = Agent::where('hash_id', $user)->first();
            $this->sendTronTrxToUsdt($amount, $details, $userID->details_from, $userID->private_key, $hash_id);
            return redirect()->back();
        }
        // $ownerAddress = 'TKANZ2knuYm4nadc7A3cKb9UyM9Ggu2zL9';
        // $private_key = 'EBBADE1DC37760D725F96A2BF5CD1243931C9D96ABE9C9F0259FA791786D60A7';

    }
    
    
    private function sendTronTrxToUsdt($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id){
        $urlSend = 'http://localhost:3000/sendTronUSDT';

        $amountInSun = intval($amount * 1000000);
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
            ])->post($urlSend, [
                'addressTo' => $addressTo,
                'amount' => $amountInSun,
                'ownerAddress' => $ownerAddress,
                'privateKey' => $ownerKey,
            ]);

            
            $hash_id_find = User::where('hash_id', $hash_id)->first();
            if($response->successful())
            {
            if($hash_id_find->hasRole('admin')){
                $user = Platform::where('hash_id', $hash_id_find->hash_id)->first();
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$user->details_from,
                ]);
                $responseBalance = $checkBalance->json();
                $amountUpdate = $responseBalance['balance'];
                Platform::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
                Agent::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('agent')){
                $user = Agent::where('hash_id', $hash_id_find->hash_id)->first();
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$user->details_from,
                ]);
                $responseBalance = $checkBalance->json();
                $amountUpdate = $responseBalance['balance'];
                Agent::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('client')){
                $user = Client::where('hash_id', $hash_id_find->hash_id)->first();
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$user->details_from,
                ]);
                $responseBalance = $checkBalance->json();
                $amountUpdate = $responseBalance['balance'];
                Client::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('market')){
                $user = Market::where('hash_id', $hash_id_find->hash_id)->first();
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$user->details_from,
                ]);
                $responseBalance = $checkBalance->json();
                $amountUpdate = $responseBalance['balance'];
                Market::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }
        }
        }
}
