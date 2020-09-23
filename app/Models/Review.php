<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'room_id',
        'member_id',
        'booking_id',
        'description',
        'rate',
    ];

    protected $appends = [
        'member_name',
        'member_avatar_url',
        'room_name',
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'rate' => 'float',
    ];

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

    /**
     * @return BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    /**
     * @return string
     */
    public function getMemberNameAttribute()
    {
        return $this->member ? $this->member->name : '';
    }

    /**
     * @return string
     */
    public function getMemberAvatarUrlAttribute()
    {
        return $this->member ? $this->member->avatar_url : '';
    }

    /**
     * @return string
     */
    public function getRoomNameAttribute()
    {
        return $this->room ? $this->room->name : '';
    }

    /**
     * @return string
     */
    public function getDateFromAttribute()
    {
        return $this->booking ? $this->booking->start_date : '';
    }

    /**
     * @return string
     */
    public function getDateToAttribute()
    {
        return $this->booking ? $this->booking->end_date : '';
    }
}
