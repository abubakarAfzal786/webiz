<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class TicketsComplete
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
        return $member->support_tickets()->where('completed', true)->orderBy('created_at', 'DESC')->get();
    }
}
