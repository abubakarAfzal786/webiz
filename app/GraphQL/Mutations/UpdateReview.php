<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Review;

class UpdateReview
{
    /**
     * @param null $_
     * @param array <string, mixed> $args
     * @return Review
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        /** @var Review $review */
        $member->reviews()->findOrFail($args['id']);

        unset($args['id']);

        $review->update($args);

        return $review;
    }
}
