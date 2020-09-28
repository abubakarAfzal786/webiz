<?php

namespace App\GraphQL\Queries;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authorize
{
    /**
     * @param null $_
     * @param array <string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        try {
            $auth = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $auth = null;
        }

        return (boolean)$auth;
    }
}
