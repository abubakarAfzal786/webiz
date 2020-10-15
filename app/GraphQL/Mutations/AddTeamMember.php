<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AddTeamMember
{
    use TwilioHelper;

    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Team|null
     */
    public function __invoke($_, array $args)
    {
        $numbers = $args['phone_numbers'];
        $team_id = $args['team_id'];

        /** @var Member $user */
        $user = auth()->user();

        /** @var Team $team */
        $myTeams = $user->my_teams->pluck('id')->toArray();
        $teams = $user->teams->pluck('id')->toArray();

        $team = null;

        if (in_array($team_id, $myTeams) || in_array($team_id, $teams)) {
            $team = Team::query()->find($team_id);
        }

        if ($team && $numbers) {
            $exist_ids = [];
            $to_invite = [];
            foreach ($numbers as $number) {
                $member = Member::query()->where('phone', $number)->first();
                if ($member) {
                    $exist_ids[$member->id] = ['phone' => $member->phone];
                } else {
                    $to_invite[] = $number;
                }
            }

            $team->members()->sync($exist_ids, false);
            foreach ($to_invite as $number) {
                $this->sendRegistrationSMS($number);
                DB::table('team_member_pivot')->insert([
                    'team_id' => $team->id,
                    'phone' => $number,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return $team;
    }
}
