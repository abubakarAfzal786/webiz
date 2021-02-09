<?php

namespace App\Http\Helpers;

use App\Models\Booking;
use App\Models\PushNotification;
use App\Models\Room;
use Exception;
use Illuminate\Support\Facades\DB;

final class BookingHelper
{
    use FCMHelper;

    /**
     * @param $booking
     * @return bool
     */
    public function extendBooking($booking)
    {
        if ($booking->out_at) {
            $booking->update(['status' => Booking::STATUS_COMPLETED]);
            return false;
        }

        /** @var Booking $next_booked */
        $next_booked = next_booked($booking);

        if ($next_booked) {
            /** @var Room $freeExist */
            $freeExist = similar_free_room($next_booked->room, $next_booked->start_date, $next_booked->end_date);

            if (!$freeExist) {
                $booking->update(['status' => Booking::STATUS_COMPLETED]);
                return false;
            } else {
                DB::beginTransaction();
                try {
                    $newBooking = $next_booked->replicate();
                    $newBooking->room_id = $freeExist->id;
                    $newBooking->save();
                    foreach ($next_booked->room_attributes as $room_attribute) {
                        $newBooking->room_attributes()->attach($room_attribute, ['quantity' => $room_attribute->pivot->quantity]);
                    }
                    $newBooking->push();
                    $next_booked->update(['status' => Booking::STATUS_CANCELED]);
                    DB::commit();

                    $data = [
                        'title' => 'שים לב! המשרד שהזמת הוחלף', // Your booked room has been changed
                        'body' => 'לחץ כאן לפרטי ההזמנה המעודכנת', // Click here for updated order details
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
                } catch (Exception $exception) {
                    DB::rollBack();
                    return false;
                }
            }
        }

        $booking->update(['status' => Booking::STATUS_EXTENDED]);

        return true;
    }
}
