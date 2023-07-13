<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'short',
        'content',
        'is_enabled',
        'thumb',
        'images',
        'seo_title',
        'seo_text_keys',
        'seo_description',
        'views',
        'type',
        'locale',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'images' => 'array',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_enabled', true)
            ->where('created_at', '<=',Carbon::now());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->MorphToMany(Tag::class, 'taggable');
    }

    public function categories(): MorphToMany
    {
        return $this->MorphToMany(Category::class, 'categorize');
    }

    public function link(): string
    {
        return route('post', $this->slug);
    }

    public function thumb()
    {
        return !empty($this->thumb) ?  '/storage/'.$this->thumb : $this->thumb;
    }

    public function images(): array
    {
        $images = [];

        if(empty($this->images)) {
            return $images;
        }

        foreach ($this->images as $image) {
            $images[] = '/storage/'.$image;
        }

        return $images;
    }

    public function getDate()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }

    public function shortLimited(?int $limit = 50): string
    {
        return Str::limit($this->short, $limit, '...');
    }
}
