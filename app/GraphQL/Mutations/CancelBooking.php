<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;

class CancelBooking
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
        /** @var Booking $booking */
        $booking = $member->bookings()->find($args['id']);

        if (!$booking) {
            return [
                'message' => 'Booking not found',
                'success' => false,
            ];
        }

        $canceledLastMonth = $member->bookings()
            ->where('start_date', '>=', Carbon::now()->subMonth())
            ->where('status', Booking::STATUS_CANCELED)
            ->count();

        if ($canceledLastMonth && $booking->start_date->diffInHours(Carbon::now()) < 25) {
            return [
                'message' => '24 hours left to your booking. Sorry, you can\'t cancel booking',
                'success' => false,
            ];
        }

        $booking->update(['status' => Booking::STATUS_CANCELED]);
        make_transaction($member->id, null, $booking->room_id, $booking->id, -$booking->price, Transaction::TYPE_ROOM);

        return [
            'message' => 'Booking successfully canceled.',
            'success' => true,
        ];
    }
}
