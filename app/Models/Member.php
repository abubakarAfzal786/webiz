<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Model implements JWTSubject
{
    use ImageUploadHelper;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'status',
        'balance',
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

    public function images()
    {
        return $this->hasMany(Image::class, 'relation_id', 'id')->where('model', self::class);
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class, 'relation_id', 'id')->where('model', self::class)->where('main', true);
    }

    public function getMainImageAttribute()
    {
        return $this->mainImage ? $this->mainImage : null;
    }

}
