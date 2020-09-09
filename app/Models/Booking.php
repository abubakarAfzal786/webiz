<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'member_id',
        'start_date',
        'end_date',
        'price',
        'status',
    ];

    protected $appends = [
        'status_name'
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    const STATUS_PENDING = 10;
    const STATUS_ACTIVE = 20;

    const DATE_TIME_LOCAL = 'Y-m-d\TH:i';

    public static function listStatuses()
    {
        return [
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_ACTIVE => __('Active'),
        ];
    }

    /**
     * @param $date
     * @return mixed
     */
    public function toDateTimeLocal($date)
    {
        return $this->$date->format(self::DATE_TIME_LOCAL);
    }

    public function getStatusNameAttribute()
    {
        return $this->listStatuses()[$this->getAttribute('status')] ?? '';
    }

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
