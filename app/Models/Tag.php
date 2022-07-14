<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilterTags(Builder $query, string $tag)
    {
        return $query->when($tag, function (Builder $query) use ($tag) {
            $query->where('slug', $tag);
        });
    }

    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }
}
