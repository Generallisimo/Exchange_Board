<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddMarketDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'details_market_from',
        'details_market_to',
    ];

    public function markets():BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}
