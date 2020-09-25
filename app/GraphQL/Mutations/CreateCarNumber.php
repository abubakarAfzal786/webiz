<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class CreateCarNumber
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Model
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        $number = $member->car_numbers()->create($args);

        return $number;
    }
}
