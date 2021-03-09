<?php

use App\Models\Booking;
use Illuminate\Database\Seeder;

class UpdateBookingsSetCompany extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::query()->with('member')->whereNull('company_id')->get();

        foreach ($bookings as $booking) {
            /** @var Booking $booking */
            $booking->update(['company_id' => $booking->member->company_id]);
        }
    }
}
