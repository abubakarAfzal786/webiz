<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\FCMHelper;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LocationState
{
    use FCMHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $out = $args['out'];

        $member->bookings()
            ->whereNotIn('status', [Booking::STATUS_CANCELED, Booking::STATUS_COMPLETED])
            ->update(['out_at' => ($out ? Carbon::now() : null)]);
            Log::channel('notifications')->info('Out at '.$out ? Carbon::now() : null." member id". $member->id);

        $ext = $member->bookings()->where('status', Booking::STATUS_EXTENDED);
        if (!$out) $ext = $ext->whereNotNull('out_at');
        $ext = $ext->get();

        foreach ($ext as $booking) {
            /** @var Booking $booking */
            if ($out && $member->mobile_token) {
                $data = [
                    'title' => 'שים לב! עקב יציאה מהמתחם ההזמתך הסתיימה', // Your booking will be stopped, because of leaving office area
                    'body' => 'איך היה לך? לחץ כאן בשביל לספר לנו.', // How was it? Click here to tell us.
                ];

                $extraData = [
                    'id' => $booking->id,
                    'type' => 'bookings',
                    'action' => 'leaving'
                ];

                PushNotification::query()->create([
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'member_id' => $booking->member_id,
                    'seen' => false,
                    'additional' => json_encode($extraData),
                ]);

                $this->sendPush($booking->member->mobile_token, $data, $extraData);
            }
        }

        return true;
    }
}
