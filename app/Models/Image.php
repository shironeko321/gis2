<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'map_id',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }
}
