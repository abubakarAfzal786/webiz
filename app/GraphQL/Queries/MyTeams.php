<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class MyTeams
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $teams */
        $teams = auth()->user()->my_teams;
        return $teams ? $teams->sortBy('created_at', SORT_DESC) : [];
    }
}
