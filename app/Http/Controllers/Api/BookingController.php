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
use App\Http\Helpers\TwilioHelper;

class BookingController extends Controller
{
    use FCMHelper,TwilioHelper;

    /**
     * @param $id
     * @param Request $request
     * @return false|JsonResponse
     */
    public function test(){

        try{
           $response= $this->sendBookingMessage("+972547919874","Abubakar",247);
            dd($response);
        }catch (Exception $exception) {
           dd($exception);
        }
    }
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
                return response()->json(['success' => false, 'message' => 'Push not sent'], 500);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Booking Completed. Push Sent'], 200);
    }
    public function testNotifications(){
        try {
            $booking = Booking::query()
                ->with(['member', 'room'])
                ->where('id', request()->get('booking_id'))->first();
            $data = [
                'title' => $booking->room->name . ' מוכן לרשותך ', // Booking started
                'body' => 'הזמנתך החלה, עבודה נעימה', // Your order has begun, pleasant work
            ];
            $extraData = [
                'id' => $booking->id,
                'type' => 'bookings',
                'action' => request()->get('action'),
            ];
            PushNotification::query()->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'member_id' => $booking->member_id,
                'seen' => false,
                'additional' => json_encode($extraData),
            ]);
            echo ($this->sendPush(request()->get('fcm_token'), $data, $extraData) ? 'success' : 'failure') . "\n";
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
