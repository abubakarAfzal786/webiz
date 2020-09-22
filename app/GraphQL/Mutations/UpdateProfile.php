<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\ImageUploadHelper;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;

class UpdateProfile
{
    use ImageUploadHelper;

    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Member
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
//        $member = auth()->user();
        $member = Member::query()->first();

        // TODO implement email and phone unique validation
//        $exist = Member::query()->where('id', '<>', $member->id)
//            ->where(function (Builder $query) use ($args) {
//                $query->where('email', $args['email'])->orWhere('phone', $args['phone']);
//            })->exists();
//        if ($exist) return null;

        if (isset($args['password'])) $args['password'] = bcrypt($args['password']);

        $member->update($args);

        $avatar = $args['avatar'] ?? null;
        if ($avatar) {
            $path = $this->uploadImage($avatar);
            if ($path) {
                $member->avatar()->delete();
                $member->avatar()->create([
                    'path' => $path,
                    'size' => $avatar->getSize(),
                    'main' => true,
                ]);
            }
        }

        return $member;
    }
}
