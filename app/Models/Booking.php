<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon out_at
 * @property Member member
 * @property Room room
 * @property int id
 * @property int member_id
 */
class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'member_id',
        'start_date',
        'end_date',
        'price',
        'status',
        'door_key',
        'logo_id',
        'out_at',
    ];

    protected $appends = [
        'status_name',
//        'similar_room',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'out_at',
        'created_at',
        'updated_at',
    ];

    const STATUS_PENDING = 10;
    const STATUS_ACTIVE = 20;
    const STATUS_COMPLETED = 30;
    const STATUS_EXTENDED = 40;
    const STATUS_CANCELED = 50;

    const DATE_TIME_LOCAL = 'Y-m-d\TH:i';

    public static function listStatuses()
    {
        return [
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_COMPLETED => __('Completed'),
            self::STATUS_EXTENDED => __('Extended'),
            self::STATUS_CANCELED => __('Canceled'),
        ];
    }

    /**
     * @param $date
     * @param bool $changeTz
     * @return mixed
     */
    public function toDateTimeLocal($date, $changeTz = false)
    {
        $notFormatted = $changeTz ? $this->$date->timezone('Asia/Jerusalem') : $this->$date;
        return $notFormatted->format(self::DATE_TIME_LOCAL);
    }

    /**
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return $this->listStatuses()[$this->getAttribute('status')] ?? '';
    }

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id')->withoutGlobalScopes();
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id')->withoutGlobalScopes();
    }

    /**
     * @return BelongsToMany
     */
    public function room_attributes()
    {
        return $this->belongsToMany(RoomAttribute::class, 'booking_attributes_pivot', 'booking_id', 'attribute_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'booking_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function logo()
    {
        return $this->belongsTo(Image::class, 'logo_id', 'id')->where('is_logo', true);
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id', 'id');
    }

    /**
     * @return Room|null
     */
    public function getSimilarRoomAttribute()
    {
        $next_booked = next_booked($this);
        $freeExist = false;

        if ($next_booked) {
            /** @var Room $freeExist */
            $freeExist = similar_free_room($next_booked->room, $next_booked->start_date, $next_booked->end_date);
        }

//        TODO check
        return $freeExist ? $freeExist : null;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes['status']) && ($attributes['status'] == self::STATUS_COMPLETED) && ($this->status == self::STATUS_EXTENDED)) {
            $room_attributes = [];
            foreach ($this->room_attributes as $room_attribute) {
                $room_attributes[] = [
                    'id' => $room_attribute->id,
                    'quantity' => $room_attribute->pivot_quantity,
                ];
            }
            $attributesToSync = get_attributes_to_sync($room_attributes);
            $addedPrice = calculate_room_price($attributesToSync, $this->room->price, $this->end_date, Carbon::now())['price'];
            make_transaction($this->member_id, null, $this->room_id, $this->id, $addedPrice, Transaction::TYPE_ROOM);
            $attributes['price'] = $this->price + $addedPrice;
            $attributes['end_date'] = Carbon::now();
        }

        $attributes['company_id'] = $this->member->company_id;

        return parent::update($attributes, $options);
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return Image|Collection
     */
    public function getLogosAttribute()
    {
        return $this->member->logos;
    }
}
