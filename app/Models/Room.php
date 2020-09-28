<?php

namespace App\Models;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

/**
 * @property Collection reviews
 * @property Collection images
 */
class Room extends Model
{
    protected $fillable = [
        'name',
        'price',
        'seats',
        'overview',
        'location',
        'lat',
        'lon',
        'status',
        'user_id',
        'type_id',
        'wifi_ssid',
        'wifi_pass',
    ];

    protected $appends = [
        'average_rate',
        'rates_count',
        'is_favorite',
    ];

    protected $casts = [
        'average_rate' => 'float'
    ];

    /**
     * @return bool|void|null
     * @throws Exception
     */
    public function delete()
    {
        foreach ($this->images as $image) {
            /** @var Image $image */
            $image->delete();
        }
        parent::delete();
    }

    protected static function booted()
    {
//        static::addGlobalScope('active', function (Builder $builder) {
//            $builder->where('status', true);
//        });
//        TODO check this
    }

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return MorphOne
     */
    public function main_image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('main', true);
    }

    /**
     * @return BelongsToMany
     */
    public function facilities()
    {
        return $this->belongsToMany(RoomFacility::class, 'room_facility_pivot', 'room_id', 'facility_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(RoomType::class, 'type_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'room_id', 'id');
    }

    /**
     * @return float|int
     */
    public function getAverageRateAttribute()
    {
        $reviews = $this->reviews()->get()->pluck('rate')->toArray();
        return $reviews ? number_format(array_sum($reviews) / count($reviews), 2) : 0;
    }

    /**
     * @return int
     */
    public function getRatesCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * @return bool
     */
    public function getIsFavoriteAttribute()
    {
        /** @var Member|User $user */
        $user = auth()->user();
        return $user->favorite_rooms ? in_array($this->id, $user->favorite_rooms()->get()->pluck('id')->toArray()) : false;
    }
}
