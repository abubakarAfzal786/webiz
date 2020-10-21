<?php

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomAttribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('room_is_busy')) {
    /**
     * @param int $id
     * @param $start
     * @param $end
     * @return bool
     */
    function room_is_busy($id, $start, $end)
    {
        return Booking::query()
            ->where('room_id', $id)
            ->where('start_date', '<=', $start)
            ->where('end_date', '>=', $end)
            ->exists();
    }
}

if (!function_exists('get_attributes_to_sync')) {
    /**
     * @param array $attributes
     * @return array
     */
    function get_attributes_to_sync($attributes)
    {
        $attributesToSync = [];
        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                $attributesToSync[$attribute['id']] = ['quantity' => $attribute['quantity']];
            }
        }
        return $attributesToSync;
    }
}

if (!function_exists('calculate_room_price')) {
    /**
     * @param array $attributesToSync
     * @param float|int $roomPrice
     * @param $time
     * @return float|int
     */
    function calculate_room_price($attributesToSync, $roomPrice, $time)
    {
        $roomAttributes = RoomAttribute::query()->whereIn('id', array_keys($attributesToSync))->get();

        foreach ($roomAttributes as $roomAttribute) {
            $roomPrice += $roomAttribute->price * $attributesToSync[$roomAttribute->id]['quantity'] * ($roomAttribute->unit == RoomAttribute::UNIT_HR ? $time : 1);
        }

        return $roomPrice;
    }
}

if (!function_exists('next_booked')) {

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    function next_booked($booking)
    {
        return Booking::query()
            ->where('room_id', $booking->room_id)
            ->whereBetween('start_date', [$booking->end_date, $booking->end_date->addHours(1)])
            ->orderBy('start_date', 'ASC')
            ->first();
    }
}


if (!function_exists('similar_free_room')) {
    /**
     * @param $room
     * @return Room|bool|Builder|mixed
     */
    function similar_free_room($booked)
    {
        $room = $booked->room;

        $sameTypeRooms = Room::query()
            ->where('id', '<>', $room->id)
            ->where('type_id', $room->type_id)
            ->get();

        if (!$sameTypeRooms->count()) return false;

        foreach ($sameTypeRooms as $sameTypeRoom) {
            /** @var Room $sameTypeRoom */
            if (!$sameTypeRoom->bookings()->whereBetween('start_date', [$booked->start_date, $booked->end_date])->exists()) {
                return $sameTypeRoom;
            }
        }

        return false;
    }
}
