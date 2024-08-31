<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddMarketDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'details_market_to',
        'name_method',
        'currency',
        'comment',
        'online'
    ];

    public function markets():BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function methodPaymets(): HasMany
    {
        return $this->hasMany(MethodPayments::class);
    }
}
