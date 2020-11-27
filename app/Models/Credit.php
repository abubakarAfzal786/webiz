<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'amount',
        'price',
    ];

    public static function calculatePrice($amount)
    {
        return $amount / 50;
    }
}
