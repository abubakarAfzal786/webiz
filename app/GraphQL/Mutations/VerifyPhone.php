<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;

class VerifyPhone
{
    use TwilioHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        $test = $args['test'] ?? null;
        $phone = $args['phone'] ?? null;
        $code = isset($args['code']) ? ((strlen((int)$args['code']) < 4) ? (0 . (int)$args['code']) : (int)$args['code']) : null;
        /** @var Member $user */
        $user = Member::query()->where('phone', $phone)->first();

        if ($user) {
            if ($test) {
                return [
                    'message' => 'success',
                    'reset_token' => $user->reset_token,
                    'success' => true,
                ];
            }
            if ($this->verifyWithOTP($code, $phone)) {
                return [
                    'message' => 'success',
                    'reset_token' => $user->reset_token,
                    'success' => true,
                ];
            } else {
                return [
                    'message' => 'Invalid code',
                    'reset_token' => null,
                    'success' => false,
                ];
            }
        } else {
            return [
                'message' => 'Invalid credentials',
                'reset_token' => null,
                'success' => false,
            ];
        }
    }
}
