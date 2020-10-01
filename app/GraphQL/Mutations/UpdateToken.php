<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateToken
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

        try {
            $member->update(['mobile_token' => $args['token']]);
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }

        return true;
    }
}
