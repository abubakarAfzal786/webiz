<?php

namespace App\GraphQL\Mutations;

use App\Models\Image;
use App\Models\Member;

class UseLogo
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Image|null
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $booking = $member->bookings()->find($args['booking_id']);
        /** @var Image $logo */
        $logo = $member->logos()->find($args['logo_id']);
        if ($booking && $logo) {
            $booking->update(['logo_id' => $logo->id]);
            return $logo;
        }
        return null;
    }
}
