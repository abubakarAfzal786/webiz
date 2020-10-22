<?php

namespace App\GraphQL\Mutations;

use App\Http\Helpers\ImageUploadHelper;
use App\Models\Member;

class UploadLogos
{
    use ImageUploadHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $logos = $args['logos'] ?? null;

        if ($logos) {
            foreach ($logos as $logo) {
                $path = $this->uploadImage($logo);
                if ($path) {
                    $member->logos()->create([
                        'path' => $path,
                        'size' => $logo->getSize(),
                        'is_logo' => true,
                    ]);
                }
            }
        }

        return $member->logos;
    }
}
