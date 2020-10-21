<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
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
        $booking = Booking::query()->find($id);

        /** @var Booking $next_booked */
        $next_booked = next_booked($booking);

        if ($next_booked) {
            /** @var Room $freeExist */
            $freeExist = similar_free_room($next_booked);

            if (!$freeExist) {
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
                $this->sendPush($newBooking->member->mobile_token, $data);
            }
        }

        $booking->update(['status' => Booking::STATUS_EXTENDED]);
        return true;
    }
}
