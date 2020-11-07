<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class UpdatePassword
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();

        if (!Hash::check($args['old_password'], $member->password)) {
            return [
                'message' => 'Old password is incorrect',
                'success' => false,
            ];
        }

        $member->update(['password' => bcrypt($args['new_password'])]);

        return [
            'message' => 'Successfully updated.',
            'success' => true,
        ];
    }
}
