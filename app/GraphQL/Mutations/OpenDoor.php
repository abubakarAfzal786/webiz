<?php

namespace App\GraphQL\Mutations;

use App\Models\Room;

class OpenDoor
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Room $room */
        $room = auth()->user();
        $booking = get_current_booking($room->id);

        if ($booking) return ($args['door_key'] == $booking->door_key);
        return false;
    }
}
