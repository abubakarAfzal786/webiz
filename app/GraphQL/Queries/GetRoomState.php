<?php

namespace App\GraphQL\Queries;

use App\Models\Room;

class GetRoomState
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return object|null
     */
    public function __invoke($_, array $args)
    {
        /** @var Room $room */
        $room = auth()->user();

        return get_current_booking($room->id);
    }
}
