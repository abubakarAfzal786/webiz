<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;

class MakeNotificationsSeen
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $notifications = $member->push_notifications()->whereIn('id', $args['ids'])->first();
        if ($notifications) {
            $notifications->update(['seen' => true]);
            return true;
        }
        return false;
    }
}
