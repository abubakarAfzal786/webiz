<?php

namespace App\GraphQL\Mutations;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateUser
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        $args['password'] = bcrypt($args['password']);
        $user = User::query()->create($args);

        return $user;
    }
}
