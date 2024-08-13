<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MethodPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_method',
        'name_currency',
    ];

    public function market_details():BelongsTo
    {
        return $this->belongsTo(AddMarketDetails::class);
    }
}
