<?php

namespace App\Models;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
}
