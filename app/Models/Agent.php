<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    use HasFactory;


    protected $fillable = [
        'hash_id',
        'balance',
        'details_from',
        'details_to',
        'private_key',
        'percent',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}
