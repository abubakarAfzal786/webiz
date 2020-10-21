<?php

namespace App\GraphQL\Queries;

use App\Models\Member;
use App\Models\Room;
use Tymon\JWTAuth\JWTAuth;

class AuthTablet
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
        /** @var Room $room */
        $room = Room::query()->where('pin', $args['pin'])->first();

        if ($room) {
            $token = $this->jwt->fromUser($room);
            $code = 200;
            return [
                'token' => $token,
                'message' => 'success',
                'success' => true,
                'room' => $room
            ];
        }

        return null;
    }
}
