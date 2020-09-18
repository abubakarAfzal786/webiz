<?php

namespace App\GraphQL\Queries;

class FavoriteRooms
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        return auth()->user()->favorite_rooms ?? [];
    }
}
