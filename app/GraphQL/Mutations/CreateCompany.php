<?php

namespace App\GraphQL\Mutations;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreateCompany
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Model
     */
    public function __invoke($_, array $args)
    {
        return Company::query()->create(['name' => $args['name']]);
    }
}
