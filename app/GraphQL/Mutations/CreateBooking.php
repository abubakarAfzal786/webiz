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

        // TODO add checker functionality and fix price

        return Booking::query()->create($args);
    }
}
