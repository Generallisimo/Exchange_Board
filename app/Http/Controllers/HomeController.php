<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //     if (Auth::user()->hasRole('admin')) {
        //         return $next($request);
        //     }
        //     // return $next($request);

        //     return abort(403, 'Unauthorized action.');
        // });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userFind = Auth::user()->hash_id;
        $userId = User::where('hash_id', $userFind)->first();
        if($userId->hasRole('admin')){
            $user = Platform::where('hash_id', $userId->hash_id)->first();
            // dd($user);
            return view('dashboard', compact('user'));
        }elseif($userId->hasRole('agent')){
            $user = Agent::where('hash_id', $userId->hash_id)->first();
            // dd($user);
            return view('dashboard', compact('user'));
        }elseif($userId->hasRole('market')){
            $user = Market::where('hash_id', $userId->hash_id)->first();
            // dd($user);
            return view('dashboard', compact('user'));
        }elseif($userId->hasRole('client')){
            $user = Client::where('hash_id', $userId->hash_id)->first();
            // dd($user);
            return view('dashboard', compact('user'));
        }
        

    }
}
