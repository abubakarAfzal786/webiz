<?php

namespace App\GraphQL\Queries;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class Faqs
{
    /**
     * @param null $_
     * @param array <string, mixed>  $args
     * @return Collection|static[]
     */
    public function __invoke($_, array $args)
    {
        $category_ids = $args['category_ids'] ?? [];
        $orderByField = $args['orderBy']['field'] ?? 'question';
        $orderByDir = $args['orderBy']['order'] ?? 'ASC';

        $faqs = Faq::query();
        if (!empty($category_ids)) {
            $faqs = $faqs->whereIn('category_id', $category_ids);
        }
        $faqs = $faqs->orderBy($orderByField, $orderByDir)->get();
        return $faqs;
    }
}
