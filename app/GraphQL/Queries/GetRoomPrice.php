<?php

namespace App\GraphQL\Queries;

use App\Models\Room;

class GetRoomPrice
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return string[]
     */
    public function __invoke($_, array $args)
    {
        $room = Room::query()->findOrFail($args['room_id']);
        $start_date = $args['start_date'];
        $end_date = $args['end_date'];
        $attributes = $args['attributes'] ?? null;
        $attributesToSync = get_attributes_to_sync($attributes);
        $roomPrice = calculate_room_price($attributesToSync, $room->price, $start_date, $end_date);

        return [
            'roomPrice' => $roomPrice['price'],
            'hourlyPrice' => $roomPrice['startPrice'],
            'discounted' => $roomPrice['discounted']
        ];
    }
}
