<?php

use App\Models\Booking;
use App\Models\Member;
use App\Models\Room;
use App\Models\RoomAttribute;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

if (!function_exists('room_is_busy')) {
    /**
     * @param int $id
     * @param Carbon $start
     * @param Carbon $end
     * @return bool
     */
    function room_is_busy(int $id, $start, $end)
    {
        $newStart = clone $start;
        $newEnd = clone $end;
        $newStart->subMinutes(Setting::getValue('booking_time_resolution', 15));
        $newEnd->addMinutes(Setting::getValue('booking_time_resolution', 15));

        return Booking::query()
            ->where('room_id', $id)
            ->where(function ($q) use ($newStart, $newEnd) {
                return $q
                    ->where(function ($query) use ($newStart, $newEnd) {
                        return $query->where('start_date', '>', $newStart)->where('start_date', '<', $newEnd);
                    })
                    ->orWhere(function ($query) use ($newStart, $newEnd) {
                        return $query->where('end_date', '>', $newStart)->where('end_date', '<', $newEnd);
                    });
            })
            ->exists();
    }
}

if (!function_exists('get_attributes_to_sync')) {
    /**
     * @param array $attributes
     * @return array
     */
    function get_attributes_to_sync(array $attributes)
    {
        $attributesToSync = [];
        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                $attributesToSync[$attribute['id']] = ['quantity' => $attribute['quantity']];
            }
        }
        return $attributesToSync;
    }
}

if (!function_exists('calculate_room_price')) {
    /**
     * @param array $attributesToSync
     * @param float|int $roomPrice
     * @param $time
     * @return float|int
     */
    function calculate_room_price(array $attributesToSync, $roomPrice, $time)
    {
        $roomAttributes = RoomAttribute::query()->whereIn('id', array_keys($attributesToSync))->get();

        foreach ($roomAttributes as $roomAttribute) {
            $roomPrice += $roomAttribute->price * $attributesToSync[$roomAttribute->id]['quantity'] * ($roomAttribute->unit == RoomAttribute::UNIT_HR ? $time : 1);
        }

        return $roomPrice;
    }
}

if (!function_exists('next_booked')) {

    /**
     * @param $booking
     * @return Builder|Model|object|null
     */
    function next_booked($booking)
    {
        return Booking::query()
            ->where('room_id', $booking->room_id)
            ->whereBetween('start_date', [$booking->end_date, $booking->end_date->addHours(1)])
            ->orderBy('start_date', 'ASC')
            ->first();
    }
}


if (!function_exists('similar_free_room')) {
    /**
     * @param $booked
     * @return Room|bool|Builder|mixed
     */
    function similar_free_room($booked)
    {
        $room = $booked->room;

        $sameTypeRooms = Room::query()
            ->where('id', '<>', $room->id)
            ->where('type_id', $room->type_id)
            ->get();

        if (!$sameTypeRooms->count()) return false;

        foreach ($sameTypeRooms as $sameTypeRoom) {
            /** @var Room $sameTypeRoom */
            if (!$sameTypeRoom->bookings()->whereBetween('start_date', [$booked->start_date, $booked->end_date->addMinutes(Setting::getValue('booking_time_resolution', 15))])->exists()) {
                return $sameTypeRoom;
            }
        }

        return false;
    }
}

if (!function_exists('generate_door_key')) {
    /**
     * @return int
     */
    function generate_door_key()
    {
        return rand(1000, 9999);
    }
}

if (!function_exists('generate_door_pin')) {
    /**
     * @return int
     */
    function generate_door_pin()
    {
        return rand(10000000, 99999999);
    }
}

if (!function_exists('generate_room_qr_token')) {
    /**
     * @return UuidInterface
     */
    function generate_room_qr_token()
    {
        return Str::uuid();
    }
}

if (!function_exists('get_current_booking')) {
    /**
     * @param $room_id
     * @return object|bool
     */
    function get_current_booking($room_id)
    {
        /** @var Room $room */
        $room = Room::query()->find($room_id);
        if ($room) {
            $now = Carbon::now();
            return $room->bookings()->where('start_date', '<=', $now)->where('end_date', '>=', $now)->first();
        }
        return null;
    }
}

if (!function_exists('get_rating_stars_div')) {
    /**
     * @param $rate
     * @return string
     */
    function get_rating_stars_div($rate)
    {
        $stars = '';
        for ($i = 1; $i <= round($rate); $i++) {
            $stars .= '<span class="icon-star"></span>';
        }

        for ($i = 1; $i <= round(5 - round($rate)); $i++) {
            $stars .= '<span class="icon-empty"></span>';
        }

        return '<div class="rating"><p>' . $stars . '</p></div>';
    }
}

if (!function_exists('make_transaction')) {
    /**
     * @param int $member_id
     * @param float $price
     * @param int|null $room_id
     * @param int|null $booking_id
     * @param int|null $credit
     * @param int $type
     * @return Model|Transaction
     */
    function make_transaction($member_id, $price, $room_id = null, $booking_id = null, $credit = null, $type = Transaction::TYPE_CREDIT)
    {
        if ($booking_id) {
            $member = Member::query()->find($member_id);
            $member->update(['balance' => $member->balance - $credit]);
        }
        return Transaction::query()->create([
            'member_id' => $member_id,
            'room_id' => $room_id,
            'booking_id' => $booking_id,
            'type' => $type,
            'credit' => $credit,
            'price' => $price,
        ]);
    }
}

if (!function_exists('generate_pass_reset_token')) {
    /**
     * @return string
     */
    function generate_pass_reset_token()
    {
        return Str::random(60);
    }
}
