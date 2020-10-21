<?php

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Database\Seeder;

class DoorKeysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::query()->whereNull('door_key')->get();

        foreach ($bookings as $booking) {
            $booking->update(['door_key' => generate_door_key()]);
        }

        $rooms = Room::query()->whereNull('pin')->get();

        foreach ($rooms as $room) {
            $room->update(['pin' => generate_door_pin()]);
        }
    }
}
