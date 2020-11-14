<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class Transactions
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array|Collection
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $transactions */
        $transactions = auth()->user()->transactions;

        return $transactions ? $transactions->sortBy('created_at', SORT_DESC) : [];
    }
}
