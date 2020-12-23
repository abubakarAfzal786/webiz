<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class CompleteAllBookings
{
    use FCMHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $bookings = $member->bookings()
            ->where('start_date', '<', Carbon::now())
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_ACTIVE, Booking::STATUS_EXTENDED])
            ->get();

        $responseData = [];

        foreach ($bookings as $key => $booking) {
            $responseData[$key]['booking_id'] = $booking->id;
            try {
                DB::beginTransaction();
                $booking->update(['status' => Booking::STATUS_COMPLETED]);

                $data = [
                    'title' => 'Booking completed.',
                    'body' => 'Booking for "' . $booking->room->name . '" completed.',
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

                $responseData[$key]['push'] = $this->sendPush($booking->member->mobile_token, $data, $extraData) ? true : false;
                $responseData[$key]['updated'] = true;
                DB::commit();
            } catch (Exception $exception) {
                $responseData[$key]['push'] = false;
                $responseData[$key]['updated'] = false;
                DB::rollBack();
            }
        }

        return $responseData;
    }
}
