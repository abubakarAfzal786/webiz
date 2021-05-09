<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\BookingHelper;
use App\Models\Booking;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\ExtendBookingHelper;

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
        $booking = $member->bookings()->find($booking_id);
        if (!$booking) return ['booking' => null, 'message' => 'User don\'t have any booking', 'success' => false];
        return (new BookingHelper())->extendBooking($booking, $extend_date);
    }
}
