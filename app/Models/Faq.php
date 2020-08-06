<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * @return BelongsTo
     */
    public function faqcategory()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id', 'id');
    }

}
