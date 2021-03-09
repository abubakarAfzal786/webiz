<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

/**
 * @property float balance
 * @property Image logo
 */
class Company extends Model
{
    protected $fillable = [
        'id',
        'name',
        'balance',
        'added_every_month',
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
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'company_id', 'id');
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
        if ($this->logo) {
            $used = Image::query()->where('id', '<>', $this->id)->where('path', $this->logo->path)->exists();
            if (!$used) $this->logo->delete();
        }
        parent::delete();
    }

    /**
     * @return string|null
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? $this->logo->url : null;
    }

    /**
     * @return Collection
     */
    public function logos()
    {
        $logos = collect([]);
        foreach ($this->members as $member) {
            /** @var Member $member */
            foreach ($member->logos as $logo) {
                $logos->push($logo);
            }
        }
        return $logos;
    }

    /**
     * @return string|null
     */
    public function getFirstLogoUrlAttribute()
    {
        return $this->logos()->first() ? $this->logos()->first()->url : null;
    }
}
