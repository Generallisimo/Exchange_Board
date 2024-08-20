<?php

namespace App\Http\Controllers;

use App\Models\AddMarketDetails;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use App\Models\MethodPayments;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExchangeController extends Controller
{
    public function index(Request $request, $client_id, $market_id, $amount){

        $exchange_id = Str::uuid();

        $percent_client_find = Client::where('hash_id', $client_id)->first();
        $percent_client = $percent_client_find->percent;
        
        $percent_market_find = Market::where('hash_id', $market_id)->first();
        $percent_market = $percent_market_find->percent;
        
        $percent_agent_find = Agent::where('hash_id', $percent_market_find->agent_id)->first();
        $percent_agent = $percent_agent_find->percent;
        
        $details_market_payment_find = AddMarketDetails::where('hash_id', $percent_market_find->hash_id)->inRandomOrder()->first();
        $details_market_payment = $details_market_payment_find->details_market_to;
        
        $details_market_find = Market::where('hash_id', $percent_market_find->hash_id)->first();
        $details_market = $details_market_find->details_from;
        $details_client_find = Client::where('hash_id', $percent_client_find->hash_id)->first();
        $details_client = $details_client_find->details_from;

        Exchange::create([
            'exchange_id' => $exchange_id,
            'client_id' => $client_id,
            'market_id' => $market_id,
            'amount' => $amount,
            'percent_client' => $percent_client,
            'percent_market' => $percent_market,
            'percent_agent' => $percent_agent,
            'details_market_payment' => $details_market_payment,
            'details_market' => $details_market,
            'details_client' => $details_client,
            // 'result',
            // 'message',
        ]);

        $methods = MethodPayments::all();

        return view('pages.exchange', compact('methods', 'client_id', 'market_id', 'amount', 'exchange_id'));
    }

    public function exchange(Request $request){

        $method = $request->input('method');
        $currency_find = MethodPayments::where('name_method', $method)->first();
        $get_currency = $currency_find->currency;

        $exchange_id = $request->input('exchange_id');

        // dd($method);

        Exchange::where('exchange_id', $exchange_id)->update([
            'method' => $method,
            'currency' => $get_currency,
        ]);;
        
        
        
        $client_id = $request->input('client_id');
        $client = Client::where('hash_id', $client_id)->first();
        
        $market_id = $request->input('market_id');
        $market = Market::where('hash_id', $market_id)->first();
        
        $wallet = AddMarketDetails::where('hash_id', $market->hash_id)->first();

        $agent = Agent::where('hash_id', $market->agent_id)->first();

        $amount = $request->input('amount');
        $send_currency = 'USDT';

        $curse = Http::get('https://api.binance.com/api/v3/ticker/price', [
            'symbol'=> $get_currency . $send_currency
        ]);

        if($curse->successful()){
            $response = $amount * $curse['price'];
            dd($response);
        }else{
            $curseReverse = Http::get('https://api.binance.com/api/v3/ticker/price', [
                'symbol'=> $send_currency . $get_currency 
            ]);



            $client_percent = $client->percent / 100;
            $market_percent = $market->percent / 100;
            $agent_percent = $agent->percent / 100;
            
            $responseReverse = $amount * (1 / $curseReverse['price']);
            $feeAll = ($client_percent + $market_percent + $agent_percent);
            $response = $responseReverse * (1 + $feeAll);
            
            
            $amountExchange = $response * $client_percent;
            // dd($amountExchange);
            $amountMarket = $response * $market_percent;
            $amountAgent = $response * $agent_percent;
            $amountClient = $response - ($amountExchange + $amountMarket + $amountAgent);
            
            $responseUser = $amount * $curseReverse['price'];

            // dd($responseReverse, $response, $curseReverse['price'], $client_percent, $market_percent, $agent_percent, $responseUser);

            return view('pages.request_change', compact(
                'wallet', 'responseUser', 'amountExchange', 
                'amountMarket', 'amountAgent', 'amountClient', 
                'client', 'market', 'agent', 'exchange_id'));
        }

    }

    public function transaction(Request $request){
        
        $client_id = $request->input('client');
        $client = Client::where('hash_id', $client_id)->first();
        
        $market_id = $request->input('market');
        $market = Market::where('hash_id', $market_id)->first();
        
        $agent_id = $request->input('agent');
        $agent = Agent::where('hash_id', $agent_id)->first();

        $exchange_id = '9QuyE4bzdz2J';
        $exchange = Platform::where('hash_id', $exchange_id)->first();

        $amountExchange = $request->input('amountExchange');
        $amountAgent = $request->input('amountAgent');
        $amountClient = $request->input('amountClient');

        $client->balance = $client->balance + $amountClient;
        $client->save();
        $agent->balance = $agent->balance + $amountAgent;
        $agent->save();
        $exchange->balance = $exchange->balance + $amountExchange;
        $exchange->save();

        $exchange_id_user = $request->input('exchange_id');
        return view('pages.confirm_pay', compact('exchange_id_user'));
    }

    public function checkStatus($exchange_id_user){
        $response = Exchange::where('exchange_id', $exchange_id_user)->first();
       return response()->json(['status'=>$response->result]);
    }

    
    
    // private function sendTronTrxToUsdt($amount, $addressTo, $ownerAddress, $ownerKey){
    //     $urlSend = 'http://localhost:3000/sendTronUSDT';

    //     $amountInSun = bcmul($amount, '1000000', 0);
        
    //     Http::withHeaders([
    //         'Content-Type' => 'application/json'
    //         ])->post($urlSend, [
    //             'addressTo' => $addressTo,
    //             'amount' => $amountInSun,
    //             'ownerAddress' => $ownerAddress,
    //             'privateKey' => $ownerKey,
    //         ]);
    //     }






    // dd( $amountExchange);

    // $this->sendTronTrxToUsdt($amountExchange, $exchange->details_from, $market->details_from, $market->private_key);
    // $this->sendTronTrxToUsdt($amountAgent, $agent->details_from, $market->details_from, $market->private_key);
    // $this->sendTronTrxToUsdt($amountClient, $client->details_from, $market->details_from, $market->private_key);

    // public function topUp(Request $request){
    //     $market_id = $request->input('market');
    //     $market = Market::where('hash_id', $market_id)->first();
        
    //     $market_from = $request->input('market_from');
    //     $amount = $request->input('amount');

    // $this->sendTronTrxToUsdt($amount, $market_from->details_from, $market->details_from, $market->private_key);

    // }
        
        // $trxMarket = Http::get('https://api.binance.com/api/v3/ticker/price', [
        //     'symbol'=> "TRXUSDT"
        // ]);            
        // $usdtToTrxMarket = $amount * (1 / $trxMarket['price']);

}



