<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
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
            $newPrice = calculate_room_price($attributesToSync, $booking->room->price, $booking->start_date, $booking->end_date);
//            TODO check
        }

        $booking->update(['status' => Booking::STATUS_COMPLETED, 'price' => $newPrice ?? $booking->price]);
        $review = $member->reviews()->where('booking_id', $booking_id)->first();
        if ($review) {
            $review->update($args);
        } else {
            $review = $member->reviews()->create($args);
        }

        return $review;
    }
}
