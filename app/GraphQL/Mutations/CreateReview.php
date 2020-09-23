<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateReview
{
    /**
     * @param null $_
     * @param array <string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        $review = Review::query()
            ->where('room_id', $args['room_id'])
            ->where('booking_id', $args['booking_id'])
            ->where('member_id', $member->id)
            ->first();

        if ($review) {
            $review->update($args);
            return $review;
        }

        $member->reviews()->create($args);

        return Review::query()->create($args);
    }
}
