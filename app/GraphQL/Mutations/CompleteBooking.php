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
        $booking = $member->bookings()->where('status', '<>', Booking::STATUS_COMPLETED)->find($id);
        if (!$booking) return false;
        if($booking->extend_minutes!==null){
          $price=calculate_room_price($attributesToSync, $booking->room->price, $booking->end_date, $booking->extend_minutes)['price'];
           make_transaction($member->id, null, $booking->room->price, $booking->id, $args['price'], Transaction::TYPE_ROOM,null,null,"Pango");
       

        }
        $booking->update(['status' => Booking::STATUS_COMPLETED]);
        return true;
    }
}
