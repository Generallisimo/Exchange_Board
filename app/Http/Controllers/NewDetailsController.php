<?php

namespace App\Http\Controllers;

use App\Models\AddMarketDetails;
use App\Models\Market;
use App\Models\MethodPayments;
use Illuminate\Http\Request;

class NewDetailsController extends Controller
{
    public function index(){

        $markets = Market::all();
        $methods = MethodPayments::all();

        return view ('pages.add_details', compact('markets', 'methods'));
    }

    public function addWallets(Request $request){
        
        $hash_id = $request->input('hash_id');
        $details_to = $request->input('details_market_to');
        $name_method = $request->input('name_method');
        $comment = $request->input('comment');

        $currencyMethod = MethodPayments::where('name_method', $name_method)->first();
        
        $currency = $currencyMethod->currency;

        AddMarketDetails::create([
            'hash_id' => $hash_id,
            'details_market_to' => $details_to,
            'name_method' => $name_method,
            'currency' => $currency,
            'comment' => $comment,
        ]);

        return redirect()->back()->with('successful', 'Wallets has been created!');
    }
}
