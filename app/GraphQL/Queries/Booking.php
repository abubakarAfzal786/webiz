<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking
{
    /**
     * @param null $_
     * @param array <string, mixed>  $args
     * @return Builder|HasMany
     */
    public function __invoke($_, array $args)
    {
        $booking_id = $args['id'];
        /** @var Member $user */
        $user = auth()->user();

        $team_bookings = $user->teams->pluck('booking_id')->toArray();
        $comp_bookings = $user->company->bookings->pluck('id')->toArray();
        $bookings = $user->bookings->pluck('id')->toArray();

        if (in_array($booking_id, $bookings) || in_array($booking_id, $team_bookings) || in_array($booking_id, $comp_bookings)) {
            return \App\Models\Booking::query()->find($booking_id);
        }

        return null;
    }
}
