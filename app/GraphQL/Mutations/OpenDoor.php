<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\IotHelper;
use App\Models\Room;

class OpenDoor
{
    use IotHelper;

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

        if ($booking && ($args['door_key'] == $booking->door_key) && $room->door_id) {
            return $this->openIotDoor($room->door_id);
        } else {
            return false;
        }
    }
}
