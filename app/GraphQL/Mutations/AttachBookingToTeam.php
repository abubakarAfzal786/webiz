<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Team;

class AttachBookingToTeam
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Team|null
     */
    public function __invoke($_, array $args)
    {
        $booking_id = $args['booking_id'];
        $team_id = $args['team_id'];

        /** @var Member $user */
        $user = auth()->user();

        /** @var Team $team */
        $myTeams = $user->my_teams->pluck('id')->toArray();
        $teams = $user->teams->pluck('id')->toArray();

        $team = null;
        $booking = $user->bookings()->where('id', $booking_id)->exists();

        if (in_array($team_id, $myTeams) || in_array($team_id, $teams)) {
            $team = Team::query()->find($team_id);
        }

        if ($team && $booking) {
            $team->update(['booking_id' => $booking_id]);
        }

        return $team;
    }
}
