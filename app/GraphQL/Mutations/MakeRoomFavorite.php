<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class MakeRoomFavorite
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Builder|Room
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $room_id = $args['id'];

        if (in_array($room_id, $member->favorite_rooms->pluck('id')->toArray())) {
            $member->favorite_rooms()->detach($room_id);
        } else {
            $member->favorite_rooms()->attach($room_id);
        }

        return Room::query()->where('id', $room_id)->firstOrFail();
    }
}
