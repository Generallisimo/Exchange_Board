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

class TopUpController extends Controller
{
    public function index(){
       
        $user = Auth::user()->hash_id;
        $role = User::where('hash_id', $user)->first();
       
        if($role->hasRole('admin')){
            $top_up = Platform::where('hash_id', $user)->first();
            return view('pages.top_up', compact('top_up'));
        }elseif($role->hasRole('market')){
            $top_up = Market::where('hash_id', $user)->first();
            return view('pages.top_up', compact('top_up'));
        }


        // elseif($role->hasRole('client')){
        //     $top_up = Client::where('hash_id', $user)->first();
        //     return view('pages.top_up', compact('top_up'));
        // }elseif($role->hasRole('agent')){
        //     $top_up = Agent::where('hash_id', $user)->first();
        //     return view('pages.top_up', compact('top_up'));
        // }
    }




    public function topUp (Request $request){

        $hash_id = $request->input('hash_id');
        $wallet = $request->input('wallet');
        $amount = $request->input('send_currency');
        
        return view('pages.confrim_status_transction', compact('wallet', 'amount', 'hash_id'));
    }
    

    public function checkTopUp($wallet,$amount, $hash_id){
        
        $amountInSun = intval($amount * 1000000);
        $url = Http::get('http://localhost:3000/check_transaction', [
            'address' => $wallet,
            'amount' => $amountInSun,
            'hours'=> '1',
        ]);
        if($url->successful()){
            $user = User::where('hash_id', $hash_id)->first();
            if($user->hasRole('admin')){
                
                $response = $url->json();
                
                $role = Platform::where('hash_id', $user->hash_id)->first();
                // $roleAgent = Agent::where('hash_id', $user->hash_id)->first();
                
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$role->details_from,
                ]);
                
                $responseBalance = $checkBalance->json();
                
                $amountUpdate = $responseBalance['balance'];
                
                Platform::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
                Agent::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
                
                return $response;

            }elseif($user->hasRole('market')){
                $response = $url->json();
                
                $role = Market::where('hash_id', $user->hash_id)->first();
                
                $checkBalance = Http::get('http://localhost:3000/check_balance', [
                    'ownerAddress'=>$role->details_from,
                ]);
                
                $responseBalance = $checkBalance->json();
                
                $amountUpdate = $responseBalance['balance'];
                
                Market::where('hash_id', $user->hash_id)->update([
                    'balance'=> $amountUpdate,
                ]);
                
                return $response;
            }
        }
    }









        // public function checkTopUpAdmin(Request $request, $amount){
        
    //     $amountInSun = intval($amount * 1000000);
        
    //     $hash_id = $request->input('hash_id');
    //     $role = User::where('hash_id', $hash_id)->first();
    //     if($role->hasRole('admin')){
    //         $user = Platform::where('hash_id', $hash_id)->first();
    //         $wallet = $user->details_to;
    //         dd($wallet);
    //         $url = Http::get('http://localhost:3000/check_transaction', [
    //             'address' => $wallet,
    //             'amount' => $amountInSun,
    //             'hours'=> '1',
    //         ]);
    //         if($url->successful()){
    //             $response = $url->json();
    //             return $response;
    //         }
    //     }elseif($role->hasRole('client')){
    //         $user = Client::where('hash_id', $hash_id)->first();
    //         $wallet = $user->details_to;
    //         $url = Http::get('http://localhost:3000/check_transaction', [
    //             'address' => $wallet,
    //             'amount' => $amountInSun,
    //             'hours'=> '1',
    //         ]);
    //         if($url->successful()){
    //             $response = $url->json();
    //             return $response;
    //         }
    //     }elseif($role->hasRole('agent')){
    //         $user = Agent::where('hash_id', $hash_id)->first();
    //         $wallet = $user->details_to;
    //         $url = Http::get('http://localhost:3000/check_transaction', [
    //             'address' => $wallet,
    //             'amount' => $amountInSun,
    //             'hours'=> '1',
    //         ]);
    //         if($url->successful()){
    //             $response = $url->json();
    //             return $response;
    //         }
    //     }elseif($role->hasRole('market')){
    //         $user = Market::where('hash_id', $hash_id)->first();
    //         $wallet = $user->details_to;
    //         $url = Http::get('http://localhost:3000/check_transaction', [
    //             'address' => $wallet,
    //             'amount' => $amountInSun,
    //             'hours'=> '1',
    //         ]);
    //         if($url->successful()){
    //             $response = $url->json();
    //             return $response;
    //         }
    //     }
        
        // $checkBalance = Http::get('http://localhost:3000/check_balance', [
        //     'ownerAddress'=>$user->details_from,
        // ]);
        // $responseBalance = $checkBalance->json();
        // $amountUpdate = $responseBalance['balance'];
    // }
}