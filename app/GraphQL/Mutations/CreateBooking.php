<?php

namespace App\GraphQL\Mutations;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateBooking
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        $args['price'] = 100;

        /** @var Booking $booking */
        $booking = Booking::query()->create($args);

        $attributes = $args['attributes'];
        if (!empty($args['attributes'])) {
            $attributesToSync = [];

            foreach ($attributes as $attribute) {
                $attributesToSync[$attribute['id']] = ['quantity' => $attribute['quantity']];
            }

            $booking->room_attributes()->attach($attributesToSync);
        }

        // TODO add checker functionality and fix price

        return $booking;
    }
}
