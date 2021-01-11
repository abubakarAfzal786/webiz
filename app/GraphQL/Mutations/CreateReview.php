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

        if (!$booking || !in_array($booking->status, [Booking::STATUS_EXTENDED, Booking::STATUS_COMPLETED])) {
            return null;
        }

        if ($booking->status == Booking::STATUS_EXTENDED) {
            $booking->update(['status' => Booking::STATUS_COMPLETED]);
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
