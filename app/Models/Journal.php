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
        'entry',
        'image_path' // Add this if you want to store image paths
    ];

    protected $dispatchesEvents = [
        'created' => JournalCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
