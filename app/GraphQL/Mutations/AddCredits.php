<?php

namespace App\GraphQL\Mutations;

use App\Models\Credit;
use App\Models\Member;

class AddCredits
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $method_id = $args['method_id'];
        $credit_id = $args['credit_id'] ?? null;
        $amount = $args['amount'] ?? null;

//            TODO charge user for $credit->price/$amount with $method_id
        if ($credit_id) {
            $credit = Credit::query()->find($credit_id);
            $member->update(['balance' => $member->balance + $credit->amount]);
            return true;
        } elseif ($amount) {
            $cost = Credit::calculatePrice($amount);
            $member->update(['balance' => $member->balance + $cost]);
            return true;
        } else {
            return false;
        }
    }
}
