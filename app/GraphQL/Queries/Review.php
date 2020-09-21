<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return HasMany
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $user */
        $user = auth()->user();
        return $user->reviews()->where('id', $args['id'])->first();
    }
}
