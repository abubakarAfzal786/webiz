<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use Exception;
use Illuminate\Support\Facades\DB;

class CompleteBookingNotify
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

        try {
            DB::beginTransaction();
            $booking->update(['status' => Booking::STATUS_COMPLETED]);

            $data = [
                'title' => 'הזמנתך הסתיימה בהצלחה', // Booking completed
                'body' => 'איך היה לך? לחץ כאן בשביל לספר לנו.', // How was it? Click here to tell us.
            ];

            $extraData = [
                'id' => $booking->id,
                'type' => 'bookings',
                'action' => 'completed',
            ];

            PushNotification::query()->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'member_id' => $booking->member_id,
                'seen' => false,
                'additional' => json_encode($extraData),
            ]);

            if ($this->sendPush($booking->member->mobile_token, $data, $extraData)) {
                DB::commit();
            } else {
                DB::rollBack();
                return false;
            }
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
