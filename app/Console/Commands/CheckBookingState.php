<?php

namespace App\Console\Commands;
use App\Http\Helpers\BookingHelper;
use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Monolog\Logger;
use App\Http\Helpers\TwilioHelper;

class CheckBookingState extends Command
{
    use FCMHelper,TwilioHelper;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check booking state and do actions';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $booking
     */
    private function bookingCompletedPush($booking)
    {
        
        if ($booking->member->mobile_token) {
            $data = [
                'title' => 'שים לב! הזמנתך הסתיימה', // Your booking finished
                'body' => 'אנא פנה את המשרד או לחץ כאן כדי להאריך את ההזמנה.', // Please contact the office or click here to extend your booking.
            ];

            $extraData = [
                'id' => $booking->id,
                'type' => 'bookings',
                'action' => 'completed'
            ];

            PushNotification::query()->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'member_id' => $booking->member_id,
                'seen' => false,
                'additional' => json_encode($extraData),
            ]);

            echo ($this->sendPush($booking->member->mobile_token, $data, $extraData) ? 'success' : 'failure') . "\n";
           Log::channel('notifications')->info('complete booking notification run at'.'--id--'.$booking->id.'--'.Carbon::now());

        }
    }

    /**
     * @param $booking
     */
    private function bookingExpiredPush($booking, $minutes)
    {
        if ($booking->member->mobile_token) {
            $data = [
                'title' => ' שים לב! הזמנתך תסתיים בעוד ' . $minutes . ' דקות ', // Your book time has expired
                'body' => 'צריך עוד זמן? לחץ כאן בשביל להאריך את ההזמנה לפני שתסתיים.',
            ];

            $extraData = [
                'id' => $booking->id,
                'type' => 'bookings',
                'action' => 'expired'
            ];

            PushNotification::query()->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'member_id' => $booking->member_id,
                'seen' => false,
                'additional' => json_encode($extraData),
            ]);

            echo ($this->sendPush($booking->member->mobile_token, $data, $extraData) ? 'success' : 'failure') . "\n";
            Log::channel('notifications')->info('expired notification run at'.'--id--'.$booking->id.'--'.Carbon::now());

        }
   
    }

    /**
     * @param $booking
     */
    private function bookingStartedPush($booking)
    {
        $now = Carbon::now();
        if ((Carbon::parse($booking->start_date)->format("Y-m-d H:i:00")==Carbon::parse($now)->format("Y-m-d H:i:00")) && ($booking->end_date->gt($now))) {
           
            Log::info('start notification run at'.$now);
            if ($booking->member->mobile_token) {
                $data = [
                    'title' => $booking->room->name . ' מוכן לרשותך ', // Booking started
                    'body' => 'הזמנתך החלה, עבודה נעימה', // Your order has begun, pleasant work
                ];

                $extraData = [
                    'id' => $booking->id,
                    'type' => 'bookings',
                    'action' => 'started',
                ];

                PushNotification::query()->create([
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'member_id' => $booking->member_id,
                    'seen' => false,
                    'additional' => json_encode($extraData),
                ]);

                echo ($this->sendPush($booking->member->mobile_token, $data, $extraData) ? 'success' : 'failure') . "\n";
                 Log::channel('notifications')->info('started notification run at'.'-- id ---'.$booking->id.'---'.$now);

            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $nowSub5 = Carbon::now()->subMinutes(5);
        Log::channel('notifications')->info('cron run at'.$now);
        $bookings = Booking::query()
            ->with(['member', 'room'])
            ->whereNotIn('status', [Booking::STATUS_COMPLETED, Booking::STATUS_CANCELED])
            ->get();

        foreach ($bookings as $booking) {
            $endClone = clone $booking->end_date;
            $endSub5 = $endClone->subMinutes(5);
            $difference=$booking->end_date->diffInHours($now);
            if ($booking->status == Booking::STATUS_PENDING) {
                if (($booking->start_date <= $now) && ($booking->end_date > $now)) {
                    // STARTED BOOKING
                    $this->bookingStartedPush($booking);
                    $booking->update(['status' => Booking::STATUS_ACTIVE]);
                }
            } elseif ($booking->status == Booking::STATUS_EXTENDED) {
                if ($booking->out_at && ($booking->out_at <= $nowSub5)) {
                    // COMPLETE BOOKING

                    $this->bookingCompletedPush($booking);
                    $booking->update(['status' => Booking::STATUS_COMPLETED]);
                    Log::channel('notifications')->info('on out at extend 1'.$now." booking_id". $booking->id);

                }
                else{
                    if($booking->end_date<=$now){
                    $extendBooking = (new BookingHelper())->extendBooking($booking,null,null,[],true,"from Cron section 1");
                      if ($extendBooking['success']!==true) {
                        // COMPLETE BOOKING
                        $this->bookingCompletedPush($booking);
                        $booking->update(['status' => Booking::STATUS_COMPLETED]);
                        Log::channel('notifications')->info('extending booking'.$now." booking_id". $booking->id);

                       }
                      }
                }

            } else {
                if (Carbon::parse($endSub5)->format("Y-m-d H:i:00")==Carbon::parse($now)->format("Y-m-d H:i:00")) {
                    // EXPIRED BOOKING
                    $this->bookingExpiredPush($booking, (int)$now->diffInMinutes($booking->end_date) + 1);
                } elseif ($booking->end_date <= $now) {
                    if ($booking->out_at) {
                        // COMPLETE BOOKING

                        $this->bookingCompletedPush($booking);
                        $booking->update(['status' => Booking::STATUS_COMPLETED]);
                        Log::channel('notifications')->info('on out at'.$now." booking_id". $booking->id);

                    } 
                    else {
                        // EXTEND BOOKING
                        $extendBooking = (new BookingHelper())->extendBooking($booking,null,null,[],true,"from cron section 2");
                        if ($extendBooking['success']!==true) {
                            // COMPLETE BOOKING
                            $this->bookingCompletedPush($booking);
                            $booking->update(['status' => Booking::STATUS_COMPLETED]);
                            Log::channel('notifications')->info('extending booking'.$now." booking_id". $booking->id);

                        }


                    }
                }
            }
        }

        return true;
    }
}
