<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 */
class Device extends Model
{
    protected $fillable = [
        'type_id',
        'device_id',
        'description',
        'state',
        'additional_information',
        'room_id',
    ];

    /**
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DeviceType::class, 'type_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
