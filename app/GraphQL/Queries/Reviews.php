<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class Reviews
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $reviews */
        $reviews = auth()->user()->reviews;
        return $reviews ? $reviews->sortBy('created_at', SORT_DESC) : [];
    }
}
