<?php

namespace App\Http\Controllers;

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

        // $id = 8;
        // $test = User::find($id);
        // $testRole = $test->hasRole('agent');
        // dd($testRole);

        return view('dashboard');
    }
}
