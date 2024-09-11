<?php

namespace App\Services\Transactions;

use App\Models\Exchange;

class TransactionServices
{

    public function index(){
        
        $exchanges = Exchange::where('result', 'await')->get();
        $exchangesSuccess = Exchange::where('result', 'success')->get();
        $exchangesArchive = Exchange::where('result', 'archive')->get();
        $exchangesDispute = Exchange::where('result', 'dispute')->get();

        return [
            'exchanges'=>$exchanges,
            'exchangesSuccess'=>$exchangesSuccess,
            'exchangesArchive'=>$exchangesArchive, 
            'exchangesDispute'=>$exchangesDispute
        ];
    }

    public function update($exchange, $status, $message){

        $result = Exchange::where('exchange_id', $exchange)->update([
            'result'=>$status,
            'message'=>$message
        ]);

        return $result ? true : "Ошибка обратитесь в поддержку"; 

    }
}