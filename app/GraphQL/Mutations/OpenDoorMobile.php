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
        if ($room) {
            $device = get_current_device($room->id, 'door');
            return $this->toggleIotDevice($device->device_id);
        } else {
            return false;
        }
    }
}
