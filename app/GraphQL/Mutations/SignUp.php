<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Exception;
use Tymon\JWTAuth\JWTAuth;

class SignUp
{
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        try {
            /** @var Member $member */
            if (isset($args['password'])) $args['password'] = bcrypt($args['password']);
            unset($args['password_confirmation']);
            $member = Member::query()->create($args);

            $token = $this->jwt->fromUser($member);

            return [
                'token' => $token,
                'message' => 'success',
                'success' => true,
                'user' => $member
            ];
        } catch (Exception $exception) {
            return [
                'token' => null,
                'message' => 'fail',
                'success' => false,
                'user' => null
            ];
        }
    }
}
