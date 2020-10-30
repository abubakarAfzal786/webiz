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
        // seed door key
        $bookings = Booking::query()->whereNull('door_key')->get();
        foreach ($bookings as $booking) {
            $booking->update(['door_key' => generate_door_key()]);
        }

        // seed room pin
        $roomsPin = Room::query()->whereNull('pin')->get();
        foreach ($roomsPin as $roomPin) {
            $roomPin->update(['pin' => generate_door_pin()]);
        }

//        // seed room qr token
//        $roomsQr = Room::query()->whereNull('qr_token')->get();
//        foreach ($roomsQr as $roomQr) {
//            $roomQr->update(['qr_token' => generate_room_qr_token()]);
//        }
    }
}
