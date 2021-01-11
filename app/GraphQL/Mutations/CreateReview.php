<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateReview
{
    /**
     * @param null $_
     * @param array <string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $booking_id = ($args['booking_id']);
        /** @var Booking $booking */
        $booking = $member->bookings()->find($booking_id);
        if (!in_array($booking->status, [Booking::STATUS_EXTENDED, Booking::STATUS_COMPLETED])) {
            return null;
        }

        if ($booking->status == Booking::STATUS_EXTENDED) {
            $attributes = $booking->room_attributes ?? null;
            $attributesToSync = get_attributes_to_sync($attributes);
            $addedPrice = calculate_room_price($attributesToSync, $booking->room->price, $booking->end_date, Carbon::now());
            $booking->update(['status' => Booking::STATUS_COMPLETED, 'price' => ($booking->price + $addedPrice)]);
            make_transaction($member->id, null, $booking->room_id, $booking->id, $addedPrice, Transaction::TYPE_ROOM);
        }

        $review = $member->reviews()->where('booking_id', $booking_id)->first();
        if ($review) {
            $review->update($args);
        } else {
            $review = $member->reviews()->create($args);
        }

        return $review;
    }
}
