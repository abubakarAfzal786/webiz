<?php

namespace App\GraphQL\Mutations;

use Illuminate\Http\UploadedFile;

class Upload
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return false|string
     */
    public function __invoke($_, array $args)
    {
        /** @var UploadedFile $file */
        $file = $args['file'];

        return $file->storePublicly('uploads');
    }
}
