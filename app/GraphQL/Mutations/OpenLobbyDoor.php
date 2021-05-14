<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\IotHelper;
use App\Models\Device;
use App\Models\Room;
use App\Models\Setting;

class OpenLobbyDoor
{
    use IotHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Room $room 
         * @args $room_id
         */
        $lobby_door_id = Setting::getValue('lobby_door_id', config('other.lobby_door_id'));
        $device = Device::where(['device_id' => $lobby_door_id, 'room_id' => $args['room_id']])->whereHas('type', function ($q) {
            $q->where('name', 'door');
        })->first();
        if ($device && ($device->device_id == $lobby_door_id)) {
            return $this->toggleIotDevice($lobby_door_id);
        } else {
            return false;
        }
    }
}
