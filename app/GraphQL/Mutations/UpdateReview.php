<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;

class UpdateReview
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Review
     */
    public function __invoke($_, array $args)
    {
        /** @var Review $review */
        $review = Review::query()->findOrFail($args['id']);

        unset($args['id']);

        $review->update($args);

        return $review;
    }
}
