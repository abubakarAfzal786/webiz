<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id', 'id');
    }
}
