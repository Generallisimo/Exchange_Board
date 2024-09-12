<?php

namespace App\Components\SendPercent;

use App\Components\CheckTXID\CheckTXID;
use App\Components\SendToUserTRON\SendTRON;
use Illuminate\Support\Facades\Http;

class SendPercent
{
    public $amount;
    public $details_to;
    public $details_from;
    public $private_key;

    public function __construct($amount, $details_to, $details_from, $private_key)
    {
        $this->amount = $amount;
        $this->details_to = $details_to;
        $this->details_from = $details_from;
        $this->private_key = $private_key;
    }

    public function update(){
        $startTime = time();
        $timeUot = 300;

        $send = (new SendTRON(
            $this->amount, 
            $this->details_to, 
            $this->details_from, 
            $this->private_key
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
                'owner'=>$this->details_from,
                'address_to'=>$this->details_to,
                'amount'=>$this->amount
            ];
        }else{
            return [
                'success'=>false,
                'message'=>'error with transaction',
                'transaction'=>$result['success'],
                'owner'=>$this->details_from,
                'address_to'=>$this->details_to,
                'amount'=>$this->amount
            ];
        }
    }
}