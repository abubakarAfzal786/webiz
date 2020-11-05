<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Collection;

class PaymentMethods
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        /** @var Collection $teams */
        $methods = auth()->user()->payment_methods;
        return $methods ? $methods->sortBy('created_at', SORT_DESC) : [];
    }
}
