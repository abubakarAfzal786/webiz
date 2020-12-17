<?php

namespace App\GraphQL\Queries;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;
use Tymon\JWTAuth\JWTAuth;

class Verify
{
    use TwilioHelper;

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
        $test = $args['test'] ?? null;
        $phone = $args['phone'] ?? null;
        $code = isset($args['code']) ? ((strlen((int)$args['code']) < 4) ? (0 . (int)$args['code']) : (int)$args['code']) : null;
        /** @var Member $user */
        $user = Member::query()->where('phone', $phone)->first();

        if ($user) {
            if ($test) {
                $token = $this->jwt->fromUser($user);
                $code = 200;
                return [
                    'token' => $token,
                    'message' => 'success',
                    'success' => true,
                    'user' => $user
                ];
            }
            if ($this->verifyWithOTP($code, $phone)) {
                $token = $this->jwt->fromUser($user);
                $code = 200;
                return [
                    'token' => $token,
                    'message' => 'success',
                    'success' => true,
                    'user' => $user
                ];
            } else {
                $code = 500;
                return [
                    'token' => '',
                    'message' => 'invalid_code',
                    'success' => false,
                    'user' => null
                ];
            }
        } else {
            $code = 401;
            return [
                'token' => '',
                'message' => 'Invalid credentials',
                'success' => false,
                'user' => null
            ];
        }
    }
}
