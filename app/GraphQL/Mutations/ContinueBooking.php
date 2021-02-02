<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\BookingHelper;
use App\Models\Member;

class ContinueBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $booking_id = $args['id'];
        $booking = $member->bookings()->find($booking_id);
        if (!$booking) return false;

        return (new BookingHelper())->extendBooking($booking);
    }
}
