<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
use App\Models\Room;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Booking|null
     */
    public function __invoke($_, array $args)
    {
        $start_date = $args['start_date'];
        $end_date = $args['end_date'];

        /** @var Member $member */
        $member = auth()->user();

        /** @var Room $room */
        $room = Room::query()->find($args['room_id']);

        if ($room && !room_is_busy($args['room_id'], $start_date, $end_date)) {
            $time = $end_date->diffInMinutes($start_date) / 60;
            $roomPrice = $room->price * $time;
            $attributes = $args['attributes'] ?? null;
            $attributesToSync = get_attributes_to_sync($attributes);
            $args['price'] = calculate_room_price($attributesToSync, $roomPrice, $time);
            $args['door_key'] = generate_door_key();
            $args['status'] = Booking::STATUS_PENDING;

            DB::beginTransaction();
            try {
                /** @var Booking $booking */
                $booking = $member->bookings()->create($args);
                $booking->room_attributes()->attach($attributesToSync);
                make_transaction($member->id, $args['price'], $args['room_id'], $booking->id, null, Transaction::TYPE_ROOM);
            } catch (Exception $exception) {
                DB::rollBack();
                return null;
            }

            DB::commit();
            return $booking;
        }
        return null;
    }
}
