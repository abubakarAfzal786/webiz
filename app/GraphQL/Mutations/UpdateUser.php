<?php

namespace App\GraphQL\Mutations;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UpdateUser
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Builder[]|Collection|Model
     */
    public function __invoke($_, array $args)
    {
        /** @var User $user */
        $user = User::query()->findOrFail($args['id']);

        if (isset($args['password'])) $args['password'] = bcrypt($args['password']);
        unset($args['id']);

        $user->update($args);

        return $user;
    }
}
