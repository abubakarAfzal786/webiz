<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;

class MakeNotificationSeen
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
        $notification = $member->push_notifications()->where('id', $args['id'])->first();
        if ($notification) {
            $notification->update(['seen' => true]);
            return true;
        }
        return false;
    }
}
