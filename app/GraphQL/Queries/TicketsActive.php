<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class TicketsActive
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        return $member->support_tickets()->where('completed', false)->orderBy('created_at', 'DESC')->get();
    }
}
