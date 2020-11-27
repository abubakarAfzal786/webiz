<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;

class AddPaymentMethod
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement payment method creation in Payment Service

        /** @var Member $user */
        $user = auth()->user();

        $method = $user->payment_methods()->create(['card_number' => '**** **** **** 1234']);

        return $method;
    }
}
