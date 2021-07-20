<?php

namespace App\Http\Helpers;

use App\Models\Booking;
use App\Models\PushNotification;
use App\Models\Room;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Helpers\TwilioHelper;
final class BookingHelper
{
    use FCMHelper,TwilioHelper;

    /**
     * @param $booking
     * @return bool
     */
    public function extendBooking($booking, $extend_date = null, $member_id = null,$attributesToSync=[],$cron=false,$source)
    {
        // if ($booking->out_at) {
        //     $booking->update(['status' => Booking::STATUS_COMPLETED]);
        //     return [
        //         'booking' => $booking,
        //         'message' => 'Booking Marked as Complete',
        //         'success' => true,
        //     ];
        // }
        if($cron==true){
            $extend_date=$booking->end_date->addMinutes(30);
        }

        /** @var Booking $next_booked 
         * @desctiption: it check the existing booking with user's new date
         */
        $next_booked = next_booked($booking, $extend_date);

        if ($next_booked) {
            /** 
             * @var Room $freeExist
             * @description:it will check the available rooms 
             * */
            $freeExist = similar_free_room($next_booked->room, $next_booked->start_date, $next_booked->end_date);

            if (!$freeExist) {
                $booking->update(['status' => Booking::STATUS_COMPLETED]);
                return [
                    'booking' => $booking,
                    'message' => 'Booking Marked as Complete',
                    'success' => true,
                ];
            } else {
                DB::beginTransaction();
                try {
                   // $newBooking = $next_booked->replicate();
                    // $newBooking->room_id = $freeExist->id;
                    // $newBooking->save();
                    // foreach ($next_booked->room_attributes as $room_attribute) {
                    //     $newBooking->room_attributes()->attach($room_attribute, ['quantity' => $room_attribute->pivot->quantity]);
                    // }
                    // $newBooking->push();
                    $next_booked->update(['room_id' => $freeExist->id]);

                    DB::commit();

                    $data = [
                        'title' => 'שים לב! המשרד שהזמת הוחלף', // Your booked room has been changed
                        'body' => 'לחץ כאן לפרטי ההזמנה המעודכנת', // Click here for updated order details
                    ];

                    $extraData = [
                        'id' => $next_booked->id,
                        'type' => 'bookings',
                        'action' => 'changed',
                    ];

                    PushNotification::query()->create([
                        'title' => $data['title'],
                        'body' => $data['body'],
                        'member_id' => $next_booked->member_id,
                        'seen' => false,
                        'additional' => json_encode($extraData),
                    ]);

                    $this->sendPush($next_booked->member->mobile_token, $data);
                } catch (Exception $exception) {
                    DB::rollBack();
                    return [
                        'booking' => null,
                        'message' => $exception->getMessage(),
                        'success' => false,
                    ];
                }
            }
        }
        if($cron==true){
            $extend_date=$booking->end_date->addMinute();
            if($booking->extend_minutes!==null){
            $extend_date=$booking->extend_minutes->addMinute();
            }
            try {

            if($booking->end_date->diffInHours($extend_date)<=12){
                   $price = calculate_room_price($attributesToSync, $booking->room->price, $booking->end_date, $extend_date)['price'];
                  if (($booking->member->balance < $price) || !$booking->member->company_id) {
                    return [
                        'booking' => null,
                        'message' => 'You don\'t have enough credits',
                        'success' => false,
                    ];
                  }else{
                if($booking->member->phone){
                      $this->sendBookingMessage($booking->member->phone,$booking->member->name,$booking->id);
                   Log::channel('notifications')->info('Send SMS'.$now." booking_id". $booking->id);

                   }
                    DB::beginTransaction();
                    $booking->update(['extend_minutes' => $extend_date, 'status' => Booking::STATUS_EXTENDED]);
                    DB::commit();
                return [
                     'booking' => $booking,
                     'message' => 'Success',
                     'success' => true,
                       ];
                    }
                 }else{
                 return [
                    'booking' => null,
                    'message' => 'something went wrong',
                    'success' => false,
                    ];
                  }
              
                }
                catch (Exception $exception) {
                    DB::rollBack();
                    return [
                        'booking' => null,
                        'message' => $exception->getMessage(),
                        'success' => false,
                    ];
                Log::channel('notifications')->info($exception->getMessage()."booking_id". $booking->id);

                }
                Log::channel('booking')->info('extending booking pango'.Carbon::now()." booking_id". $booking->id." Source ->".$source);

        }
        else{
            if ($extend_date !== null && $extend_date->gt($booking->end_date) && $booking->end_date->diffInHours($extend_date)<=12 && $booking->status!==Booking::STATUS_EXTENDED) {
                try {
                $price = calculate_room_price($attributesToSync, $booking->room->price, $booking->end_date, $extend_date)['price'];
                if (($booking->member->balance < $price) || !$booking->member->company_id) {
                    return [
                        'booking' => null,
                        'message' => 'You don\'t have enough credits',
                        'success' => false,
                    ];
                }else{
                  DB::beginTransaction();
                  $transaction= make_transaction($booking->member_id, null, $booking->room_id, $booking->id, $price, Transaction::TYPE_ROOM,null,null,"Extend Booking");
                   $booking->update(['end_date' => $extend_date, 'status' => Booking::STATUS_EXTENDED]);
                 DB::commit();
                Log::channel('booking')->info('extending booking'.Carbon::now()." booking_id". $booking->id." Source ->".$source);

                }
                }
                catch (Exception $exception) {
                    DB::rollBack();
                    return [
                        'booking' => null,
                        'message' => $exception->getMessage(),
                        'success' => false,
                    ];
                }
            }
             else {
                return [
                    'booking' => null,
                    'message' => 'something went wrong',
                    'success' => false,
                ];
            }
        }
        return [
            'booking' => $booking,
            'message' => 'Success',
            'success' => true,
        ];
    }
}
