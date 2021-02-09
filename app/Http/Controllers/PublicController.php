<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
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

        return view('frontscreen', compact('bookings'));
    }
}
