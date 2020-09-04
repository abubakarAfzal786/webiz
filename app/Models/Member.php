<?php

namespace App\Models;

use App\Http\Helpers\ImageUploadHelper;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    public function mainImage()
    {
        return $this->images()->where('main', true);
    }

    public function getMainImageAttribute()
    {
        return $this->mainImage ? $this->mainImage : null;
    }

}
