<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketBoardController extends Controller
{
    public function index (){
        return view('pages.market_board');
    }
}
