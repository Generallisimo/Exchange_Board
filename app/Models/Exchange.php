<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_id',
        'method',
        'currency',
        'client_id',
        'market_id',
        'amount',
        'result',
        'message',
        'percent_client',
        'percent_market',
        'percent_agent',
        'details_market_payment',
        'details_market',
        'details_client',
    ];


}
