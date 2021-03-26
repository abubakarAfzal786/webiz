<?php

namespace App\GraphQL\Queries;

use App\Models\Booking;
use App\Models\Member;
use Illuminate\Support\Collection;

class Bookings
{
    /**
     * @param null $_
     * @param array <string, mixed>  $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $user */
        $user = auth()->user();

        $team_bookings = $user->teams->pluck('booking_id')->toArray();
        $my_bookings = $user->bookings->pluck('id')->toArray();
        $comp_bookings = $user->company->bookings->pluck('id')->toArray();

        $ids = $team_bookings + $my_bookings + $comp_bookings;

        /** @var Collection $bookings */
        return Booking::query()->whereIn('id', $ids)->orderBy('created_at', 'DESC')->get();
    }
}
