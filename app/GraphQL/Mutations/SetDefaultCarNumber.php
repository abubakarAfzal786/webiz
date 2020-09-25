<?php

namespace App\GraphQL\Mutations;

use App\Models\CarNumber;
use App\Models\Member;

class SetDefaultCarNumber
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return CarNumber
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        /** @var CarNumber $number */
        $number = $member->car_numbers()->findOrFail($args['id']);
        $member->car_numbers()->where('default', true)->update(['default' => false]);

        $number->update(['default' => true]);

        return $number;
    }
}
