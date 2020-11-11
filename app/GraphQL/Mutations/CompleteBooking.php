<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;

class CompleteBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        // booking ID
        $id = $args['id'];

        /** @var Member $member */
        $member = auth()->user();
        $booking = $member->bookings()->find($id);
        if (!$booking) return false;

        $booking->update(['status' => Booking::STATUS_COMPLETED]);
        return true;
    }
}
