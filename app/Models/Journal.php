<?php

namespace App\Models;

use App\Events\JournalCreated;
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

    protected $dispatchesEvents = [
        'created' => JournalCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
