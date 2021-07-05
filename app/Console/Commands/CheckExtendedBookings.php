<?php

namespace App\Console\Commands;

use App\Http\Helpers\BookingHelper;
use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\PushNotification;
use Illuminate\Console\Command;

class CheckExtendedBookings extends Command
{
    use FCMHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:extended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check extended bookings';

    /**
     * Create a new command instance.
     *
     * @return void
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
                'action' => 'completed',
            ];

            PushNotification::query()->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'member_id' => $booking->member_id,
                'seen' => false,
                'additional' => json_encode($extraData),
            ]);

            echo ($this->sendPush($booking->member->mobile_token, $data, $extraData) ? 'success' : 'failure') . "\n";
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $bookings = Booking::query()
            ->with(['member', 'room'])
            ->where('status', Booking::STATUS_EXTENDED)
            ->get();

        foreach ($bookings as $booking) {
            $extendBooking = (new BookingHelper())->extendBooking($booking,null,null,[],false,"From Check Extend Booking file");
            if (!$extendBooking) {
                $this->bookingCompletedPush($booking);
                $booking->update(['status' => Booking::STATUS_COMPLETED]);
            }
        }
    }
}
