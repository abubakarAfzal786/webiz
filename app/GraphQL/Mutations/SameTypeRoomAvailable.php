<?php

namespace App\GraphQL\Mutations;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class SameTypeRoomAvailable
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Room|bool|Builder|mixed
     */
    public function __invoke($_, array $args)
    {
        $now = Carbon::now();
        $id = $args['id'];
//        $start_date = $args['start_date'] ?? $now;
//        $end_date = $args['end_date'] ?? $now;

        $room = Room::query()->findOrFail($id);

        $freeExist = similar_free_room($room);

        return $freeExist ? $freeExist : null;
    }
}
