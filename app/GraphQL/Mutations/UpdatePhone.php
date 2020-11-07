<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;

class UpdatePhone
{
    use TwilioHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $first = $args['first'];
        $phone = $args['phone'];
        $code = $args['code'] ?? null;

        if ($first) {
            $exist = Member::query()->where('phone', $phone)->where('id', '<>', auth()->id())->exists();
            if ($exist) {
                return [
                    'message' => 'Phone number already used',
                    'success' => false,
                ];
            }
            if ($this->sendVerificationSMS($phone)) {
                return [
                    'message' => 'Verification code sent via SMS',
                    'success' => true,
                ];
            } else {
                return [
                    'message' => 'Failed to send verification code',
                    'success' => false,
                ];
            }
        } else {
            if ($code && $this->verifyWithOTP($code, $phone)) {
                $member->update(['phone' => $phone]);
                return [
                    'message' => 'Phone number verified & updated',
                    'success' => true,
                ];
            } else {
                return [
                    'message' => 'Incorrect verification code',
                    'success' => false,
                ];
            }
        }
    }
}
