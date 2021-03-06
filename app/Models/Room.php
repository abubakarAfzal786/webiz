<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property Collection reviews
 * @property Collection images
 * @property Collection facilities
 * @property mixed price
 * @property int id
 * @property boolean monthly
 * @property mixed lat
 * @property mixed lon
 * @property mixed location
 */
class Room extends Authenticatable implements JWTSubject
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
        'pin',
        'number',
        'company_id',
        'monthly',
    ];

    protected $appends = [
        //        'average_rate',
        //        'rates_count',
        //        'is_favorite',
        //        'available_at',
    ];

    protected $casts = [
        'average_rate' => 'float'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', true)->where('monthly', false);
        });
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
     * @return HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class, 'room_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'room_id', 'id');
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
        /** @var Member $user */
        $user = auth()->user();
        return $user->favorite_rooms ? in_array($this->id, $user->favorite_rooms()->get()->pluck('id')->toArray()) : false;
    }

    /**
     * @return Carbon|HigherOrderBuilderProxy|mixed
     */
    public function getAvailableAtAttribute()
    {
        return $this->attributes['available_at'] ?? get_room_available_from($this);
    }

    /**
     * @param $value
     */
    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = ($value !== null) ? intval($value) : null;
    }

    /**
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getDoorIdAttribute()
    {
        $doorTypeId = DeviceType::query()->where('name', 'door')->first();
        if ($doorTypeId) {
            $door = $this->devices()->where('type_id', $doorTypeId)->first();
            return $door->device_id ?? null;
        }
        return null;
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
