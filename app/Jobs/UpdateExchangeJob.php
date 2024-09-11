<?php

namespace App\Jobs;

use App\Components\CheckTXID\CheckTXID;
use App\Components\SendToUserTRON\SendTRON;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use App\Models\Platform;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateExchangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $exchange;
    public $timeout = 620;
    public $tries = 1;

    public function __construct($exchange)
    {
        $this->exchange = $exchange;    
    }

    public function handle(): void
    {
        $response = Exchange::where('exchange_id', $this->exchange)->first();

        $client = Client::where('hash_id', $response->client_id)->first();

        $market = Market::where('hash_id', $response->market_id)->first();
        $agent = Agent::where('hash_id', $market->agent_id)->first();

        $platform = Platform::find(1);
           
        if($response->result === 'to_success'){
            
            Log::info($market->details_from);
            Log::info($market->private_key);
            Log::info($agent->details_from);
            Log::info($platform->details_from);
            Log::info($client->details_from);
            $sendAgent = $this->update(
                $response->amount_agent,
                $agent->details_from,
                $market->details_from,
                $market->private_key
            );

            $sendPlatform = $this->update(
                $response->amount_client,
                $platform->details_from,
                $market->details_from,
                $market->private_key
            );

            $sendClient = $this->update(
                $response->result_client,
                $client->details_from,
                $market->details_from,
                $market->private_key
            );

            if($sendAgent['success'] && $sendClient['success'] && $sendPlatform){
                $this->store(
                    $this->exchange,
                    $sendAgent['transaction'],
                    $sendAgent['owner'],
                    $sendAgent['address_to'],
                    $sendAgent['amount'],
                    $sendAgent['message']
                );

                $this->store(
                    $this->exchange,
                    $sendPlatform['transaction'],
                    $sendPlatform['owner'],
                    $sendPlatform['address_to'],
                    $sendPlatform['amount'],
                    $sendPlatform['message']
                );

                $this->store(
                    $this->exchange,
                    $sendClient['transaction'],
                    $sendClient['owner'],
                    $sendClient['address_to'],
                    $sendClient['amount'],
                    $sendClient['message']
                );

                $response->update([
                    'result'=>'success',
                    'message'=>'successful'
                ]);
            }elseif($sendAgent['success'] === false || $sendClient['success'] === false || $sendPlatform['success'] === false){
                $this->store(
                    $this->exchange,
                    $sendAgent['transaction'],
                    $sendAgent['owner'],
                    $sendAgent['address_to'],
                    $sendAgent['amount'],
                    $sendAgent['message']
                );

                $this->store(
                    $this->exchange,
                    $sendPlatform['transaction'],
                    $sendPlatform['owner'],
                    $sendPlatform['address_to'],
                    $sendPlatform['amount'],
                    $sendPlatform['message']
                );

                $this->store(
                    $this->exchange,
                    $sendClient['transaction'],
                    $sendClient['owner'],
                    $sendClient['address_to'],
                    $sendClient['amount'],
                    $sendClient['message']
                );

                $response->update(['result'=>'error', 'message'=>'Ошибка транзакции']);
            }

        }
    }

    private function update($amount, $details_to, $details_from, $private_key){
        $startTime = time();
        $timeUot = 300;

        $send = (new SendTRON(
            $amount, 
            $details_to, 
            $details_from, 
            $private_key
            ))->send();
        
        $checkTXID = (new CheckTXID($send['message']));
        $isSuccessful = false;

        while(time() - $startTime < $timeUot){
            $result = $checkTXID->check();

            if($result['success'] === true){
                $isSuccessful = true;
                break;
            }

            sleep(10);
        }

        if($isSuccessful){
            return [
                'success'=>true,
                'message'=>'successful transaction',
                'transaction'=>$result['success'],
                'owner'=>$details_from,
                'address_to'=>$details_to,
                'amount'=>$amount
            ];
        }else{
            return [
                'success'=>false,
                'message'=>'error with transaction',
                'transaction'=>$result['success'],
                'owner'=>$details_from,
                'address_to'=>$details_to,
                'amount'=>$amount
            ];
        }
    }

    private function store($exchange_id, $transaction_id, $owner, $adress_to, $amount, $status){
        Transaction::create([
            'exchange_id'=>$exchange_id,
            'transaction_id'=>$transaction_id,
            'owner_address'=>$owner,
            'address_to'=>$adress_to,
            'amount'=>$amount,
            'status'=>$status
        ]);
    }
}                   