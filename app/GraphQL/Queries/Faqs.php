<?php

namespace App\GraphQL\Queries;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class Faqs
{
    /**
     * @param  null $_
     * @param  array <string, mixed>  $args
     * @return Collection|static[]
     */
    public function __invoke($_, array $args)
    {
        $category_ids = $args['category_ids'] ?? [];
        $orderByField = $args['orderBy']['field'] ?? 'question';
        $orderByDir = $args['orderBy']['order'] ?? 'ASC';

        return Faq::query()->whereIn('category_id', $category_ids)->orderBy($orderByField, $orderByDir)->get();
    }
}
