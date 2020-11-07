<?php

namespace App\GraphQL\Queries;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class Authenticate
{
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array|JsonResponse
     */
    public function __invoke($_, array $args)
    {
        try {
            if (!$token = auth('api')->attempt($args)) {
                $code = 401;
                return [
                    'token' => '',
                    'message' => 'Invalid credentials',
                    'success' => false,
                    'user' => null
                ];
            }
        } catch (JWTException $e) {
            Log::error($e);
            $code = 500;
            return [
                'token' => '',
                'message' => 'could_not_create_token',
                'success' => false,
                'user' => null
            ];
        }

        $user = auth('api')->user();
        $code = 200;
        return [
            'token' => $token,
            'message' => 'success',
            'success' => true,
            'user' => $user
        ];
    }
}
