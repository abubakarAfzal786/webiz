<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAttribute extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'price',
    ];

    protected $appends = [
        'unit_name'
    ];

    const UNIT_PC = 10;
    const UNIT_HR = 20;

    /**
     * @return array
     */
    public static function listUnits()
    {
        return [
            self::UNIT_PC => __('pc'),
            self::UNIT_HR => __('hr'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getUnitNameAttribute()
    {
        return $this->listUnits()[$this->getAttribute('unit')] ?? '';
    }
}
