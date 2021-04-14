<?php

namespace App\GraphQL\Mutations;

use App\Models\Company;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ConnectCompany
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function __invoke($_, array $args)
    {
        $company = Company::query()->find($args['company_id']);

        if ($company) {
            /** @var Member $member */
            $member = auth()->user();
            $member->update(['company_id' => $company->id]);
            return $company;
        } else {
            return null;
        }
    }
}
