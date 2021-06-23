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
     * @return array
     */
    public function __invoke($_, array $args)
    {
        $start_date = $args['start_date'];
        $end_date = $args['end_date'];

        /** @var Member $member */
        $member = auth()->user();

        /** @var Room $room */
        $room = Room::query()->find($args['room_id']);

        if ($room && !room_is_busy($args['room_id'], $start_date, $end_date,null,$member->id)) {
            $attributes = $args['attributes'] ?? null;
            $attributesToSync = get_attributes_to_sync($attributes);
            $args['price'] = calculate_room_price($attributesToSync, $room->price, $start_date, $end_date)['price'];

            if (($member->balance < $args['price']) || !$member->company_id) {
                return [
                    'booking' => null,
                    'message' => 'You don\'t have enough credits',
                    'success' => false,
                ];
            }

            $args['door_key'] = generate_door_key();
            $args['status'] = Booking::STATUS_PENDING;
            $args['out_at'] = $end_date;
            $args['company_id'] = $member->company_id;
            DB::beginTransaction();
            try {
                /** @var Booking $booking */
                $booking = $member->bookings()->create($args);
                $booking->room_attributes()->attach($attributesToSync);
                make_transaction($member->id, null, $args['room_id'], $booking->id, $args['price'], Transaction::TYPE_ROOM);
            } catch (Exception $exception) {
                DB::rollBack();
                return [
                    'booking' => null,
                    'message' => 'Something went wrong',
                    'success' => false,
                ];
            }

            DB::commit();

            return [
                'booking' => $booking,
                'message' => 'Room successfully booked',
                'success' => true,
            ];
        }
        return [
            'booking' => null,
            'message' => 'Room is busy',
            'success' => false,
        ];
    }
}
