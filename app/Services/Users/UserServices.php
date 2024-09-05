<?php


namespace App\Services\Users;

use App\Components\checkBalance\CheckBalanceAgent;
use App\Components\checkBalance\CheckBalanceClient;
use App\Components\checkBalance\CheckBalanceMarket;
use App\Components\GenerateWallet\GenerateWallet;
use App\Components\SendToUserTRX\SendTRX;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;
use Illuminate\Support\Str;

class UserServices
{
 
    public function create(){
        $hash_id = Str::random(12);
        $agents = Agent::all();

        return [
            'hash_id'=>$hash_id,
            'agents'=>$agents
        ];
    }

    public function store(array $data_request){
        $response = new GenerateWallet();
        $generate_data = $response->createWallet();

        
        if ($generate_data->successful()){
            $data = $generate_data->json();

            $sendTRX = new SendTRX($data['address']);
            $resultTrx = $sendTRX->sendTRX();

            if($resultTrx === true){
                
                $user = User::create([
                    'hash_id'=>$data_request['hash_id'],
                    'password'=>$data_request['password']
                ]);
        
                $user->assignRole($data_request['role']);

                if($user->hasRole('agent')){
                    $this->createAgent(
                        $data_request['hash_id'], 
                        $data['address'], 
                        $data_request['details_to'], 
                        $data_request['percent'],
                        $data['privateKey']    
                    );
                }elseif($user->hasRole('market')){
                    $this->createMarket(
                        $data_request['hash_id'], 
                        $data['address'], 
                        $data_request['details_to'], 
                        $data_request['percent'],
                        $data_request['agent_id'],
                        $data['privateKey']    
                    );
                }elseif($user->hasRole('client')){
                    $this->createClient(
                        $data_request['hash_id'], 
                        $data['address'], 
                        $data_request['details_to'], 
                        $data_request['percent'],
                        $data['privateKey']    
                    );
                };

                return true;
            }else{
                return 'Ошибка при отправке TRX: ';
            }
        }
            
            
        
    }

    protected function createAgent($hash_id, $details_from, $details_to, $percent, $private_key){
        $agent = Agent::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            'private_key'=>$private_key,
        ]);

        new CheckBalanceAgent($agent);
    }

    
    protected function createMarket($hash_id, $details_from, $details_to, $percent, $agent_id, $private_key){
        $market = Market::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            'agent_id'=>$agent_id,
            'private_key'=>$private_key,
        ]);

        new CheckBalanceMarket($market);
    }

    
    protected function createClient($hash_id, $details_from, $details_to, $percent, $private_key){
        
        $link = url("api/payment/{$hash_id}");

        $client = Client::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            'api_link'=>$link,
            'private_key'=>$private_key,
        ]);

        new CheckBalanceClient($client);
    }

}