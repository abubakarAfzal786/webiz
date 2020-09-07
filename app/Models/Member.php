<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
    public function mainImage()
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

}
