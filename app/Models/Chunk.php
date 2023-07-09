<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chunk extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'body',
        'order',
        'position',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean'
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true)
            ->where('created_at', '<=',Carbon::now());
    }
}
