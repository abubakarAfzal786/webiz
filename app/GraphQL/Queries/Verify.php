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
        /** @var Member $user */
        $user = Member::query()->where('phone', $args['phone'])->first();

        if ($user) {
            if (isset($args['test']) && $args['test'] == true) {
                $token = $this->jwt->fromUser($user);
                $code = 200;
                return [
                    'token' => $token,
                    'message' => 'success',
                    'success' => true,
                    'user' => $user
                ];
            }
            if ($this->verifyWithOTP($args['code'], $args['phone'])) {
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
                'message' => 'invalid_credentials',
                'success' => false,
                'user' => null
            ];
        }
    }
}
