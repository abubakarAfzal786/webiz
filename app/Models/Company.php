<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Company extends Model
{
    protected $fillable = [
        'name',
        'balance',
    ];

    protected $appends = [
        'logo_url',
    ];

    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'company_id', 'id');
    }

    /**
     * @return MorphOne
     */
    public function logo()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return bool|void|null
     * @throws Exception
     */
    public function delete()
    {
        $this->logo->delete();
        parent::delete();
    }

    /**
     * @return string|null
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? $this->logo->url : null;
    }
}
