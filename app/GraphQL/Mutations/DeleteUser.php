<?php

namespace App\GraphQL\Mutations;

use App\User;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteUser
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        /** @var User $user */
        $user = User::query()->findOrFail($args['id']);

        try {
            $user->delete();
            return true;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
