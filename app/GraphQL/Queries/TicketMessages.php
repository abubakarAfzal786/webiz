<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class TicketMessages
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        $ticket = $member->support_tickets()->where('id', $args['id'])->first();
        if ($ticket) {
            return $ticket->messages;
        }
        return [];
    }
}
