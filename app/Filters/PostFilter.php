<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class PostFilter
{
    public function filter()
    {
        return
            [
                'price', 'content', 'worker.name',
                AllowedFilter::callback('item', function (Builder $query, $value) {
                    $query->where('content', 'like', "%{$value}%")
                        ->orWhere('price', 'like', "%{$value}%")
                        ->orWhereHas('worker', function ($query) use ($value) {
                            $query->where('name', 'like', "%{$value}%");
                        });
                })
            ];
    }
}
