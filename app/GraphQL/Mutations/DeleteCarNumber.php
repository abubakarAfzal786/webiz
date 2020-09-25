<?php

namespace App\GraphQL\Mutations;

use App\Models\CarNumber;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteCarNumber
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        /** @var CarNumber $number */
        $number = $member->car_numbers()->findOrFail($args['id']);

        try {
            $number->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
