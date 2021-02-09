<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\IotHelper;
use App\Models\Room;

class OpenDoorMobile
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
        $room = Room::query()->find($args['room_id']);

        if ($room->door_id) {
            return $this->openIotDoor($room->door_id);
        } else {
            return false;
        }
    }
}
