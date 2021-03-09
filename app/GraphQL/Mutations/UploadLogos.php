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

        $ids = [];
        if ($logos) {
            foreach ($logos as $logo) {
                $path = $this->uploadImage($logo);
                if ($path) {
                    $data = [
                        'path' => $path,
                        'size' => $logo->getSize(),
                        'is_logo' => true,
                    ];
                    $newLogo = $member->logos()->create($data);
                    if ($member->company->logo) $member->company->logo()->delete();
                    $data['main'] = true;
                    $member->company->logo()->create($data);
                    $ids[] = $newLogo->id;
                }
            }
        }

        return $member->logos()->whereIn('id', $ids)->get();
    }
}
