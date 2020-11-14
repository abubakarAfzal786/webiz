<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property Collection favorite_rooms
 * @property string password
 */
class Member extends Authenticatable implements JWTSubject
{
    use ImageUploadHelper;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'status',
        'balance',
        'user_id',
        'password',
        'mobile_token',
    ];

    protected $appends = [
        'favorites_count',
        'avatar_url',
        'car_number',
    ];

    protected $hidden = [
        'password',
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
            $builder->where('status', true);
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
    public function avatar()
    {
        return $this->morphOne(Image::class, 'imageable')->where('main', true);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'member_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'member_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function favorite_rooms()
    {
        return $this->belongsToMany(Room::class, 'member_room_favorite_pivot', 'member_id', 'room_id');
    }

    /**
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorite_rooms()->count();
    }

    /**
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? $this->avatar->url : '';
    }

    /**
     * @return HasMany
     */
    public function car_numbers()
    {
        return $this->hasMany(CarNumber::class, 'member_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function car_number_default()
    {
        return $this->hasOne(CarNumber::class, 'member_id', 'id')->where('default', true);
    }

    /**
     * @return string
     */
    public function getCarNumberAttribute()
    {
        return $this->car_number_default ? $this->car_number_default->number : '';
    }

    /**
     * @return HasMany
     */
    public function push_notifications()
    {
        return $this->hasMany(PushNotification::class, 'member_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function my_teams()
    {
        return $this->hasMany(Team::class, 'owner_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Member::class, 'team_member_pivot', 'member_id', 'team_id')
            ->withPivot(['phone', 'joined'])
            ->withTimestamps();
    }

    /**
     * @return MorphMany
     */
    public function logos()
    {
        return $this->morphMany(Image::class, 'imageable')->where('is_logo', true);
    }

    /**
     * @return HasMany
     */
    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class, 'member_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function support_tickets()
    {
        return $this->hasMany(SupportTicket::class, 'member_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'member_id', 'id');
    }

}
