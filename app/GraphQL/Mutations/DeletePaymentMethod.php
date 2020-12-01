<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\PaymentMethod;
use Exception;

class DeletePaymentMethod
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     * @throws Exception
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $method_id = $args['method_id'];
        $pms = $member->payment_methods->pluck('id')->toArray();

        if (in_array($method_id, $pms)) {
            $member->update(['pm_id' => null]);
            PaymentMethod::query()->find($method_id)->delete();
            return true;
        } else {
            return false;
        }
    }
}
