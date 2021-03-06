<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'member_id',
        'room_id',
        'booking_id',
        'method_id',
        'type',
        'credit',
        'price',
        'company_id',
        'description',
    ];

    const TYPE_ROOM = 10;
    const TYPE_CREDIT = 20;

    const STATUS_PENDING = 10;
    const STATUS_PAID = 20;

    public static function listTypes()
    {
        return [
            self::TYPE_ROOM => __('Booking'),
            self::TYPE_CREDIT => __('Credit'),
        ];
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
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
