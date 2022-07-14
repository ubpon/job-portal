<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilterTags(Builder $query, string $tag)
    {
        return $query->when($tag, function (Builder $query) use ($tag) {
            $query->whereHas('tags', function (Builder $builder) use ($tag) {
                $builder->where('slug', $tag);
            });
        });
    }

    public function scopeFilterJobs(Builder $query, string $search)
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $builder) use ($search) {
                $searchQuery = trim($search);
                $builder
                    ->orWhere('title', 'like', "%{$searchQuery}%")
                    ->orWhere('company', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        });
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
