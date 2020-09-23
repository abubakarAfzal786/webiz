<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteReview
{
    /**
     * @param null $_
     * @param array <string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        /** @var Review $review */
        $member->reviews()->findOrFail($args['id']);

        try {
            $review->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
