<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\BookingHelper;
use App\Models\Member;

class ExtendBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $booking_id = $args['booking_id'];
        $extend_date = $args['date'];
        $attributes = $args['attributes'] ?? [];
        $booking = $member->bookings()->find($booking_id);
        if (!$booking) return ['booking' => null, 'message' => 'User don\'t have any booking', 'success' => false];
        $attributes = $args['attributes'] ?? [];
        $attributesToSync = get_attributes_to_sync($attributes);
        return (new BookingHelper())->extendBooking($booking, $extend_date, $member->id, $attributesToSync,false,"From Extend Booking Mutation");
    }
}
