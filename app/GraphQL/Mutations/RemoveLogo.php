<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Log;

class RemoveLogo
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $logo_id = $args['id'];

        $logo = $member->logos()->find($logo_id);
        if ($logo) {
            try {
                $logo->delete();
                return true;
            } catch (Exception $exception) {
                Log::error($exception);
            }
        }

        return false;
    }
}
