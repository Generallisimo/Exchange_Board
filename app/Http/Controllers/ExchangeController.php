<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ExchangeController extends Controller
{
    public function index(){
        return view('pages.exchange');
    }

    public function requestChange(Request $request){

        $user_id = Auth::user();
        $client = Client::where('hash_id', $user_id->hash_id)->first();
        $market = Market::all()->random(1)->first();
        $agent = Agent::where('hash_id', $market->agent_id)->first();

        
        // dd($market);
        // dd($agent);
        // dd($client);

        $send_currency = $request->input('send_currency');
        $you_send = $request->input('you_send');
        $get_currency = $request->input('get_currency');

        $get = Http::get("https://api.binance.com/api/v3/ticker/price", [
            'symbol'=> $send_currency . $get_currency,
        ]);

        if($get->successful()){
            $get_amount = $you_send * $get['price'];

            $fee_agent = $agent->percent / 100;
            $fee_market = $market->percent / 100;
            $fee_client = $client->percent / 100;

            $fee = $get_amount * ($fee_agent + $fee_client + $fee_market);
            $response = $get_amount - $fee;

        }else{
            $responseReverse = Http::get("https://api.binance.com/api/v3/ticker/price", [
                'symbol' => $get_currency . $send_currency
            ]);
            $formatData = $you_send * (1 / $responseReverse['price']);
            $get_amount = number_format($formatData, 8);

            $fee_agent = $agent->percent / 100;
            $fee_market = $market->percent / 100;
            $fee_client = $client->percent / 100;


            $feeFormat = $get_amount * ($fee_agent + $fee_client + $fee_market);
            $fee = number_format($feeFormat, 8);
            $responseFormat = $get_amount - $fee;
            $response = number_format($responseFormat, 8);

            return view('pages.request_change',compact('user_id', 'market', 'send_currency', 'you_send', 'get_currency', 'response'));
        }
        
        return view('pages.request_change',compact('user_id', 'market', 'send_currency', 'you_send', 'get_currency', 'response'));
    }

    public function exchange(Request $request){
        
    }
}



// dd(' Изначально: ' . $get_amount . ' Стало: ' . $responseFormat . " или " . $feeFormat 
// . " процент fee_agent: " . $fee_agent
// . " процент fee_market: " . $fee_market
// . " процент fee_client: " . $fee_client
// );


