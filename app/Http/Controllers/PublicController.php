<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function frontscreen($id)
    {
        $now = Carbon::now();

        $bookings = Booking::query()
            ->with(['room', 'member', 'logo'])
            ->whereNotIn('status', [Booking::STATUS_CANCELED, Booking::STATUS_COMPLETED])
            ->where('start_date', '<=', $now)
            ->where(function ($q) use ($now) {
                return $q->where('end_date', '>=', $now)->orWhere('status', Booking::STATUS_EXTENDED);
            })
            ->get();

        $rooms = Room::query()->where('monthly', true)->get();

        return view('frontscreen', compact('bookings', 'rooms'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function book($id)
    {
        $booking = Booking::query()->findOrFail($id);
        $geo_href = ($booking->room->lat && $booking->room->lon) ? ('geo:' . $booking->room->lat . ',' . $booking->room->lon) : ('http://maps.google.com/?q=' . $booking->room->location);

        return view('book', compact('booking', 'geo_href'));
    }
}
