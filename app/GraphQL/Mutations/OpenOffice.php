<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\IotHelper;
use App\Models\Device;
use App\Models\Room;

class OpenOffice
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
        $booking = get_current_booking($args['room_id']);
        $device = get_current_device($booking->room->id, 'door');
        if ($booking && ($args['door_key'] == $booking->door_key)) {
            return $this->toggleIotDevice($device->device_id);
        } else {
            return false;
        }
    }
}
