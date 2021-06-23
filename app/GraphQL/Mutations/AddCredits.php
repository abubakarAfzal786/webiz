<?php

namespace App\GraphQL\Mutations;

use App\Models\Credit;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;

class AddCredits
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
//        $method_id = $args['method_id'];
        $credit_id = $args['credit_id'] ?? null;
        $amount = $args['amount'] ?? null;

        if (!$credit_id && !$amount) return false;
        // TODO charge user for $credit->price/$amount with $method_id

        if ($credit_id) {
            /** @var Credit $credit */
            $credit = Credit::query()->find($credit_id);
            $amount = $credit->amount;
            $price = $credit->price;
        } else {
            $price = Credit::calculatePrice($amount);
        }

        DB::beginTransaction();
        try {
            $member->update(['balance' => $member->balance + $amount]);
            make_transaction($member->id, $price, null, null, $amount,null,null,null,'Add Credit from app');
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }
}
