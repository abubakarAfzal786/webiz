<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;
use App\Notifications\MemberResetPassword;
use Exception;

class RestorePassword
{
    use TwilioHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        $email = $args['email'] ?? null;
        $phone = $args['phone'] ?? null;
        $test = $args['test'] ?? null;

        if ($email) {
            /** @var Member $member */
            $member = Member::query()->where('email', $email)->first();
            $token = generate_pass_reset_token();
            $member->update(['reset_token' => $token]);
            try {
                $member->notify(new MemberResetPassword($token));
                return [
                    'message' => 'Reset link successfully sent to email',
                    'success' => true,
                ];
            } catch (Exception $exception) {
                return [
                    'message' => 'Failed to send verification email',
                    'success' => false,
                ];
            }
        } elseif ($phone) {
            if ($test) {
                return [
                    'message' => 'TEST Verification. Use verify query in TEST mode to confirm.',
                    'success' => true,
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
        }

        return [
            'message' => 'Please provide email or phone',
            'success' => false,
        ];
    }
}
