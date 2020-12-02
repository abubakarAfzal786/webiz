<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
use Carbon\Carbon;

class CancelBooking
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        /** @var Booking $booking */
        $booking = $member->bookings()->find($args['id']);
        if (!$booking || ($booking && $booking->end_date->diffInHours(Carbon::now()) < 25)) return false;

        $booking->update(['status' => Booking::STATUS_CANCELED]);
        return true;
    }
}
