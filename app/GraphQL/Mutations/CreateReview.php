<?php

namespace App\GraphQL\Mutations;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateReview
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        $review = Review::query()->where('room_id', $args['room_id'])->where('member_id', $args['member_id'])->first();

        if ($review) {
            $review->update($args);
            return $review;
        }

        return Review::query()->create($args);
    }
}
