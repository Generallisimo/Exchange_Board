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

        $ownerAddress = 'TLwBnPPSnqyze6Z5PFupUHMdpcknRghKrc';
        $private_key = '6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e';
        $this->sendTronTrxToUsdt($amount, $details, $ownerAddress, $private_key, $hash_id);

        return redirect()->back();
    }
    
    
    private function sendTronTrxToUsdt($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id){
        $urlSend = 'http://localhost:3000/sendTronUSDT';

        $amountInSun = bcmul($amount, '1000000', 0);
        
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
                // dd($amount, $user->balance);
                $amountUpdate = $user->balance - $amount;
                Platform::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('agent')){
                $user = Agent::where('hash_id', $hash_id_find->hash_id)->first();
                $amountUpdate = $user->balance - $amount;
                Agent::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('client')){
                $user = Client::where('hash_id', $hash_id_find->hash_id)->first();
                $amountUpdate = $user->balance - $amount;
                Client::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }elseif($hash_id_find->hasRole('market')){
                $user = Market::where('hash_id', $hash_id_find->hash_id)->first();
                $amountUpdate = $user->balance - $amount;
                Market::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
            }
        }
        }
}
