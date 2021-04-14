<?php

namespace App\GraphQL\Queries;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchCompany
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder[]|Collection
     */
    public function __invoke($_, array $args)
    {
        return Company::query()->where('name', 'LIKE', '%' . ($args['name'] ?? null) . '%')->get();
    }
}
