<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    protected $fillable = [
        'date',
        'height',
        'weight',
        'entry'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
