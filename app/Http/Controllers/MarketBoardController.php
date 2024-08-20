<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class MarketBoardController extends Controller
{
    public function index (){
        $exchanges = Exchange::where('result', 'await')->get();
        $exchangesSuccess = Exchange::where('result', 'success')->get();
        $exchangesArchive = Exchange::where('result', 'archive')->get();
        return view('pages.market_board', compact('exchanges', 'exchangesSuccess', 'exchangesArchive'));
    }

    public function success ($exchange){
        Exchange::where('exchange_id', $exchange)->update([
            'result'=>'success',
            'message'=>'successful'
        ]);
        return redirect()->back();
    }
    
    public function archive($exchange){
        Exchange::where('exchange_id', $exchange)->update([
            'result'=>'archive',
            'message'=>'Send message to Support'
        ]);
        return redirect()->back();

    }
}
