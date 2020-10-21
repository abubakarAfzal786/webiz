<?php

namespace App\Console\Commands;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckBookingState extends Command
{
    use FCMHelper;

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();

        $bookings = Booking::query()
            ->with(['member', 'room'])
            ->where(DB::raw('DATE(start_date)'), '=', $today)
            ->where('status', '<>', Booking::STATUS_COMPLETED)
            ->get();

        foreach ($bookings as $booking) {
            $token = $booking->member->mobile_token;

            if (($booking->status != Booking::STATUS_EXTENDED) && ($booking->end_date <= $now)) {
                if ($token) {
                    $data = [
                        'title' => 'Your book time has expired',
                        'body' => 'Open the notification to take action',
                    ];
                    echo ($this->sendPush($booking->member->mobile_token, $data) ? 'success' : 'failure') . "\n";
                }

                // TODO check
                // $booking->update(['status' => Booking::STATUS_COMPLETED]);
            }

            if ($booking->status == Booking::STATUS_PENDING) {
                if (($booking->start_date <= $now) && ($booking->end_date > $now)) {
                    if ($token) {
                        $data = [
                            'title' => 'Booking started.',
                            'body' => 'Booking for "' . $booking->room->name . '" started.',
                        ];
                        echo ($this->sendPush($booking->member->mobile_token, $data) ? 'success' : 'failure') . "\n";
                    }

                    $booking->update(['status' => Booking::STATUS_ACTIVE]);
                }
            }
        }

        return true;
    }
}
