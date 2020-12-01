<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;

class ChoosePaymentMethod
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return mixed|null
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $method_id = $args['method_id'];
        $pms = $member->payment_methods->pluck('id')->toArray();

        if (in_array($method_id, $pms)) {
            $member->update(['pm_id' => $method_id]);
            return $member->payment_methods->find($method_id);
        } else {
            return null;
        }
    }
}
