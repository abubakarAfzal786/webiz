<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function room()
    {
        return $this->hasMany(Room::class, 'type_id', 'id');
    }
}
