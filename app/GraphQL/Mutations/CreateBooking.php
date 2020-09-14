<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Booking|void
     */
    public function __invoke($_, array $args)
    {
        $start_date = $args['start_date'];
        $end_date = $args['end_date'];

        $isBusy = Booking::query()
            ->where('room_id', $args['room_id'])
            ->where('start_date', '<=', $start_date)
            ->where('end_date', '>=', $end_date)
            ->exists();

        if (!$isBusy) {
            $room = Room::query()->find($args['room_id']);
            $time = $end_date->diffInMinutes($start_date) / 60;
            $roomPrice = $room->price * $time;

            $attributes = $args['attributes'];
            $attributesToSync = [];
            if (!empty($args['attributes'])) {
                foreach ($attributes as $attribute) {
                    $attributesToSync[$attribute['id']] = ['quantity' => $attribute['quantity']];
                }
            }

            $roomAttributes = RoomAttribute::query()->whereIn('id', array_keys($attributesToSync))->get();

            foreach ($roomAttributes as $roomAttribute) {
                $roomPrice += $roomAttribute->price * $attributesToSync[$roomAttribute->id]['quantity'] * ($roomAttribute->unit == RoomAttribute::UNIT_HR ? $time : 1);
            }

            $args['price'] = $roomPrice;

            /** @var Booking $booking */
            $booking = Booking::query()->create($args);

            $booking->room_attributes()->attach($attributesToSync);

            return $booking;
        }
    }
}
