<?php

namespace App\Services\Transactions;

use App\Jobs\Exchange\AgentJob;
use App\Jobs\Exchange\ClientJob;
use App\Jobs\Exchange\PlatformJob;
use App\Jobs\Exchange\UpdateJob;
use App\Jobs\UpdateExchangeJob;
use App\Models\Client;
use App\Models\Exchange;
use Illuminate\Support\Facades\Auth;

class TransactionServices
{

    public function index(){
        
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('support')) {
            $exchanges = Exchange::where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('result', 'fraud')->orderBy('created_at', 'desc')->get();

        }elseif($user->hasRole('market')){
            $exchanges = Exchange::where('market_id', $user->hash_id)->where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('market_id', $user->hash_id)->where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('market_id', $user->hash_id)->where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('market_id', $user->hash_id)->where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('market_id', $user->hash_id)->where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('market_id', $user->hash_id)->where('result', 'fraud')->orderBy('created_at', 'desc')->get();

            // dd($exchangesSuccess);
        }elseif($user->hasRole('agent')){
            $exchanges = Exchange::where('agent_id', $user->hash_id)->where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('agent_id', $user->hash_id)->where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('agent_id', $user->hash_id)->where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('agent_id', $user->hash_id)->where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('agent_id', $user->hash_id)->where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('agent_id', $user->hash_id)->where('result', 'fraud')->orderBy('created_at', 'desc')->get();
        }
        return [
            'exchanges'=>$exchanges,
            'exchangesSuccess'=>$exchangesSuccess,
            'exchangesArchive'=>$exchangesArchive, 
            'exchangesDispute'=>$exchangesDispute,
            'exchangesError'=>$exchangesError,
            'exchangesFraud'=>$exchangesFraud
        ];
    }

    public function update($exchange, $status, $message){

        $result = Exchange::where('exchange_id', $exchange)->update([
            'result'=>$status,
            'message'=>$message
        ]);
        if($status === 'fraud'){
            $exchange_id = Exchange::where('exchange_id', $exchange)->first();
            $client = Client::where('hash_id', $exchange_id->client_id)->first();
            $currentFraudValue = $client->fraud;
            $client->update([
                'fraud' => $currentFraudValue + 1
            ]);
        }
        UpdateJob::dispatch($exchange);

        return $result ? true : "Ошибка обратитесь в поддержку"; 

    }
}