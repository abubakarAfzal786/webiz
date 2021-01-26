<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use App\Models\Room;

class ContinueBooking
{
    use FCMHelper;

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

        /** @var Booking $next_booked */
        $next_booked = next_booked($booking);

        if ($next_booked) {
            /** @var Room $freeExist */
            $freeExist = similar_free_room($next_booked->room, $next_booked->start_date, $next_booked->end_date);

            if (!$freeExist) {
//                TODO check
                $booking->update(['status' => Booking::STATUS_COMPLETED]);
                return false;
            } else {
                $newBooking = $next_booked->replicate();
                $newBooking->room_id = $freeExist->id;
                $newBooking->save();
                foreach ($next_booked->room_attributes as $room_attribute) {
                    $newBooking->room_attributes()->attach($room_attribute, ['quantity' => $room_attribute->pivot->quantity]);
                }
                $newBooking->push();

                $data = [
                    'title' => 'Your booked room has been changed',
                    'body' => 'Open the notification to take action',
                ];

                $extraData = [
                    'id' => $newBooking->id,
                    'type' => 'bookings',
                    'action' => 'changed',
                ];

                PushNotification::query()->create([
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'member_id' => $newBooking->member_id,
                    'seen' => false,
                    'additional' => json_encode($extraData),
                ]);

                $this->sendPush($newBooking->member->mobile_token, $data);
            }
        }

        $booking->update(['status' => Booking::STATUS_EXTENDED]);
        return true;
    }
}
