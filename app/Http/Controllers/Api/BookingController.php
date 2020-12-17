<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    use FCMHelper;

    /**
     * @param $id
     * @param Request $request
     * @return false|JsonResponse
     */
    public function complete($id, Request $request)
    {
        /** @var Member $member */
        $member = auth()->user();
        $booking = $member->bookings()->find($id);
        if (!$booking) return response()->json(['success' => false, 'message' => 'Booking not found'], 500);

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
                return response()->json(['success' => false, 'message' => 'Push not sent'], 500);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Booking Completed. Push Sent'], 200);
    }
}
