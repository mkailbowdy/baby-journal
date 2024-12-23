<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Baby extends Model
{
    protected $fillable = [
        'first_name',
        'user_id'
    ];

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
