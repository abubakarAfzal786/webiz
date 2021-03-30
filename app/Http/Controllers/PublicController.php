<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function frontscreen()
    {
        $now = Carbon::now('Asia/Jerusalem');

        $bookings = Booking::query()
            ->with(['room', 'member', 'logo'])
            ->whereNotIn('status', [Booking::STATUS_CANCELED, Booking::STATUS_COMPLETED])
            ->where('start_date', '<=', $now)
            ->where(function ($q) use ($now) {
                return $q->where('end_date', '>=', $now)->orWhere('status', Booking::STATUS_EXTENDED);
            })
            ->get();

        $nowPlus30 = Carbon::now('Asia/Jerusalem')->addMinutes(30);
        $coming = Booking::query()
            ->with(['room', 'member', 'logo'])
            ->whereNotIn('status', [Booking::STATUS_CANCELED, Booking::STATUS_COMPLETED])
            ->where('start_date', '>=', $now)
            ->where('start_date', '<=', $nowPlus30)
            ->get();

        $rooms = Room::query()->withoutGlobalScopes()->where('monthly', true)->get();
        $time = strtoupper(Carbon::now('Asia/Jerusalem')->format('H:i'));
        $date = strtoupper(Carbon::now('Asia/Jerusalem')->format('D, d M Y'));
        $temp = null;

        try {
            $url = "https://api.openweathermap.org/data/2.5/weather?units=metric&id=293397&appid=" . config("other.openweather_api");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $res = curl_exec($ch);
            curl_close($ch);

            $temp = json_decode($res)->main->temp ?? null;
            $temp = $temp ? (int)$temp : null;
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return view('frontscreen', compact('bookings', 'rooms', 'time', 'date', 'temp', 'coming'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function book($id)
    {
        /** @var Booking $booking */
        $booking = Booking::query()->whereNotIn('status', [Booking::STATUS_CANCELED, Booking::STATUS_COMPLETED])->findOrFail($id);
        $geo_href = ($booking->room->lat && $booking->room->lon) ? ('geo:' . $booking->room->lat . ',' . $booking->room->lon) : ('http://maps.google.com/?q=' . $booking->room->location);

        return view('book', compact('booking', 'geo_href'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function qrRedirect()
    {
        $ipod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iphone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $ipad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");

        if ($ipod || $iphone || $ipad) {
            return redirect('https://apps.apple.com/us/app/webiz/id1491648662');
        } else if ($android) {
            return redirect('https://play.google.com/store/apps/details?id=com.cyberfuze.webiz');
        } else {
            return redirect('https://www.webiztlv.co.il');
        }
    }
}
