<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarNumber extends Model
{
    protected $fillable = [
        'member_id',
        'number',
        'default',
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
