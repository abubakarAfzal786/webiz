<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;

class ExtendBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        $booking_id = $args['booking_id'];
        $extend_date = $args['date'];

        /** @var Member $member */
        $member = auth()->user();

        /** @var Booking $booking */
        $booking = Booking::find($booking_id);

        if ($booking && !empty($extend_date)) {

            DB::beginTransaction();
            try {
                /** @var Booking $booking */
                $booking->end_date = $extend_date;
                $booking->save();
            } catch (Exception $exception) {
                DB::rollBack();
                return [
                    'booking' => null,
                    'message' => 'Something went wrong',
                    'success' => false,
                ];
            }

            DB::commit();

            return [
                'booking' => $booking,
                'message' => 'Booking Date successfully Updated',
                'success' => true,
            ];
        }

        return [
            'booking' => null,
            'message' => 'Booking Not Found',
            'success' => false,
        ];
    }
}
