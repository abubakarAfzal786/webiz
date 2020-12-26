<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'privileges',
        'price',
    ];

    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'package_id', 'id');
    }
}
