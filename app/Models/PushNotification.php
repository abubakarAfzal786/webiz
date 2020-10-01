<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PushNotification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'member_id',
        'seen',
        'additional',
    ];

    /**
     * @return array|mixed
     */
    public function getAdditionalAttribute()
    {
        return $this->additional ? json_decode($this->additional) : [];
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
