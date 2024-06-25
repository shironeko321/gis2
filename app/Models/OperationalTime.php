<?php

namespace App\Models;

use App\Casts\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'open',
        'close',
        'map_id',
    ];

    public function casts()
    {
        return [
            'open' => Time::class,
            'close' => Time::class,
        ];
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}
