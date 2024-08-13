<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index(){
        
        $userAuth = Auth::user()->hash_id;
        $userCheck = User::where('hash_id', $userAuth)->first();

        if($userCheck->hasRole('client')){
            $user = Client::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }elseif($userCheck->hasRole('market')){
            $user = Market::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }elseif($userCheck->hasRole('agent')){
            $user = Agent::where('hash_id', $userAuth)->first();;
            return view('pages.withdrawal', compact('user'));
        }

    }
}
