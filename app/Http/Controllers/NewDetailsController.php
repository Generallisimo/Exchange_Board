<?php

namespace App\Http\Controllers;

use App\Models\AddMarketDetails;
use App\Models\Market;
use Illuminate\Http\Request;

class NewDetailsController extends Controller
{
    public function index(){

        $markets = Market::all();

        // dd($markets);

        return view ('pages.add_details', compact('markets'));
    }

    public function addWallets(Request $request){
        $hash_id = $request->input('hash_id');
        $details_from = $request->input('details_market_from');
        $details_to = $request->input('details_market_to');

        // dd($request->all());
        AddMarketDetails::create([
            'hash_id' => $hash_id,
            'details_market_from' => $details_from,
            'details_market_to' => $details_to,
        ]);

        return redirect()->back()->with('successful', 'Wallets has been created!');
    }
}
