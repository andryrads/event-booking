<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CommonQueryScopes
{
    public function scopeFilterByDate(Builder $query, $date): Builder
    {
        return $date ? $query->whereDate('date', $date) : $query;
    }

    public function scopeSearchByTitle(Builder $query, $title): Builder
    {
        return $title ? $query->where('title', 'ILIKE', "%$title%") : $query;
    }
}
