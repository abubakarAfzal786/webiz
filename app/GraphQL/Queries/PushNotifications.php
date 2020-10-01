<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class PushNotifications
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        return $member->push_notifications()->where('seen', $args['seen'])->orderBy('created_at', 'DESC')->get();
    }
}
