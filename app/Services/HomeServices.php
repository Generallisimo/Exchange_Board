<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use App\Models\Platform;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeServices
{
    public function index(){
        $userFindAll = Auth::user();
        $userFind = $userFindAll->hash_id;
        $user = $this->user($userFind);
        
        $exchangeArchive = $this->exchange('archive');
        $exchangeDispute = $this->exchange('dispute');
        $exchangeFraud = $this->exchange('fraud');
        $exchangeSuccess = $this->exchange('success');
        $exchangeAwait = $this->exchange('await');
        $exchangeError = $this->exchange('error');

        $sumClient = Client::sum('balance');
        $sumMarket = Market::sum('balance');

        $platform = Platform::find(1)->hash_id;
        $sumAgent = Agent::where('hash_id', '!=', $platform)->sum('balance');

        $marketOnline = Market::where('status', 'online')->take(10)->get();
        $marketOnlineCount = Market::where('status', 'online')->count();
        $marketOffline = Market::where('status', 'offline')->take(10)->get();
        $marketOfflineCount = Market::where('status', 'offline')->count();
 
        $client = null;
        if ($userFindAll->hasRole('client')) {
            $client = Client::where('hash_id', $userFind)->first();
        }


        return [
            'user'=>$user,
            'exchangeArchive'=>$exchangeArchive['exchange'],
            'exchangeDispute'=>$exchangeDispute['exchange'],
            'exchangeFraud'=>$exchangeFraud['exchange'],
            'exchangeSuccess'=>$exchangeSuccess['exchange'],
            'exchangeAwait'=>$exchangeAwait['exchange'],
            'exchangeError'=>$exchangeError['exchange'],
            'exchangeArchiveCount'=>$exchangeArchive['exchangeCount'],
            'exchangeDisputeCount'=>$exchangeDispute['exchangeCount'],
            'exchangeFraudCount'=>$exchangeFraud['exchangeCount'],
            'exchangeSuccessCount'=>$exchangeSuccess['exchangeCount'],
            'exchangeAwaitCount'=>$exchangeAwait['exchangeCount'],
            'exchangeErrorCount'=>$exchangeError['exchangeCount'],
            'sumClient'=>$sumClient,
            'sumAgent'=>$sumAgent,
            'sumMarket'=>$sumMarket,
            'marketOnline'=>$marketOnline,
            'marketOffline'=>$marketOffline,
            'marketOnlineCount'=>$marketOnlineCount,
            'marketOfflineCount'=>$marketOfflineCount,
            'client'=>$client
        ];

    }

    protected function user($hash_id){
        $userId = User::where('hash_id', $hash_id)->first();

        if($userId->hasRole('admin')){
            return Platform::where('hash_id', $userId->hash_id)->first();
        }elseif($userId->hasRole('agent')){
            return Agent::where('hash_id', $userId->hash_id)->first();
        }elseif($userId->hasRole('market')){
            return Market::where('hash_id', $userId->hash_id)->first();
        }elseif($userId->hasRole('client')){
            return Client::where('hash_id', $userId->hash_id)->first();
        }
    }

    protected function exchange($status){
        $exchange = Exchange::where('result', $status)->latest()->take(10)->get();
        $exchangeCount = Exchange::where('result', $status)->count();

        return [
            'exchange'=>$exchange,
            'exchangeCount'=>$exchangeCount
        ];
    }

    public function show($period, $hash_id){
        $startDate = Carbon::now();
        $endDate = Carbon::now();
    
        switch ($period) {
            case 'day':
                $startDate->startOfDay();
                $endDate->endOfDay();
                break;
            case 'week':
                $startDate->startOfWeek();
                $endDate->endOfWeek();
                break;
            case 'month':
                $startDate->startOfMonth();
                $endDate->endOfMonth();
                break;
            case 'year':
                $startDate->startOfYear();
                $endDate->endOfYear();
                break;
        }

        $user = User::where('hash_id', $hash_id)->first();
        if ($user->hasRole('admin')) {
            $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['success'])
                ->get();

        }elseif($user->hasRole('market')){
            $exchanges = Exchange::where('market_id', $user->hash_id)->get();
            
            $transactions = collect();

            foreach($exchanges as $exchange){
                $exchangeTransactions = Transaction::where('exchange_id', $exchange->exchange_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['success'])
                    ->get();
                
    
                $transactions = $transactions->merge($exchangeTransactions);
            }
        }elseif($user->hasRole('client')){
            $exchanges = Exchange::where('client_id', $user->hash_id)->get();
            
            $transactions = collect();

            foreach($exchanges as $exchange){
                $exchangeTransactions = Transaction::where('exchange_id', $exchange->exchange_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['success'])
                    ->get();
                
    
                $transactions = $transactions->merge($exchangeTransactions);
            }
        }elseif($user->hasRole('agent')){
            $exchanges = Exchange::where('agent_id', $user->hash_id)->get();
            
            $transactions = collect();

            foreach($exchanges as $exchange){
                $exchangeTransactions = Transaction::where('exchange_id', $exchange->exchange_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('status', ['success'])
                    ->get();
                
    
                $transactions = $transactions->merge($exchangeTransactions);
            }
        }
    
        $labels = $transactions->groupBy(function($date) use ($period) {
            return Carbon::parse($date->created_at)->format($this->getFormat($period));
        })->keys()->toArray();
    
        $values = $transactions->groupBy(function($date) use ($period) {
            return Carbon::parse($date->created_at)->format($this->getFormat($period));
        })->map(function($group) {
            return $group->sum('amount');
        })->values()->toArray();
    
        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }
    

    private function getFormat($period)
    {
        switch ($period) {
            case 'day':
                return 'H:i';
            case 'week':
                return 'Y-m-d';
            case 'month':
                return 'Y-m-d';
            case 'year':
                return 'Y-m';
            default:
                return 'Y-m-d';
        }
    }
}