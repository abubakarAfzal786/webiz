<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
     * @return BelongsToMany
     */
    public function facilities()
    {
        return $this->belongsToMany(RoomFacility::class, 'room_facility_pivot', 'room_id', 'facility_id');
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
