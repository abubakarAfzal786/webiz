<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Tymon\JWTAuth\JWTAuth;

class NewPassword
{
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        $token = $args['token'] ?? null;
        $phone = $args['phone'] ?? null;

        /** @var Member $member */
        if ($token) {
            $member = Member::query()->where('reset_token', $token)->first();
        } elseif ($phone) {
            $member = Member::query()->where('phone', $phone)->first();
        } else {
            return [
                'message' => 'Please provide token or phone number',
                'token' => null,
                'success' => true,
                'user' => null,
            ];
        }

        $member->update(['password' => bcrypt($args['new_password'])]);

        return [
            'message' => 'Password successfully restored',
            'token' => $this->jwt->fromUser($member),
            'success' => true,
            'user' => $member,
        ];
    }
}
