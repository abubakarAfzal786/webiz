<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class Bookings
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $bookings */
        $bookings = auth()->user()->bookings;
        return $bookings ? $bookings->sortBy('created_at', SORT_DESC) : [];
    }
}
