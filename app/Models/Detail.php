<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'open',
        'close',
        'daily',
        'map_id',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}
