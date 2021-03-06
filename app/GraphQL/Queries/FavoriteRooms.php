<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class FavoriteRooms
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $favorite_rooms */
        $favorite_rooms = auth()->user()->favorite_rooms;
        return $favorite_rooms ? $favorite_rooms->sortBy('created_at', SORT_DESC) : [];
    }
}
