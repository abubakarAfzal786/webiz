<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string number
 */
class CarNumber extends Model
{
    protected $fillable = [
        'member_id',
        'number',
        'default',
        'label',
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
