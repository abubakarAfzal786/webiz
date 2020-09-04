<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomFacility extends Model
{
    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * @return BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_facility_pivot', 'facility_id', 'room_id');
    }
}
