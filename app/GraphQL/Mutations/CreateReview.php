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

        $review = $member->reviews()
            ->where('room_id', $args['room_id'])
            ->where('booking_id', $args['booking_id'])
            ->first();

        $member->bookings()->find($args['booking_id'])->update(['status' => Booking::STATUS_COMPLETED]);

        if ($review) {
            $review->update($args);
        } else {
            $review = $member->reviews()->create($args);
        }

        return $review;
    }
}
