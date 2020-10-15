<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;

class Team
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Builder|null
     */
    public function __invoke($_, array $args)
    {
        $id = $args['id'];

        /** @var Member $user */
        $user = auth()->user();

        $myTeams = $user->my_teams->pluck('id')->toArray();
        $teams = $user->teams->pluck('id')->toArray();

        if (in_array($id, $myTeams) || in_array($id, $teams)) {
            return \App\Models\Team::query()->find($id);
        }

        return null;
    }
}
