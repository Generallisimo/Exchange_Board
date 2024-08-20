<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'balance',
        'details_from',
        'private_key',
        'details_to',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
