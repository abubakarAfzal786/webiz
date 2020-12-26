<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\Package;

class ChoosePackage
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Package
     */
    public function __invoke($_, array $args)
    {
        $package_id = $args['id'];
        /** @var Package $package */
        $package = Package::query()->find($package_id);

        /** @var Member $member */
        $member = auth()->user();

        $member->update(['package_id' => $package_id]);

        return $package;
    }
}
