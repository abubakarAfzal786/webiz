<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $fillable = [
        'title',
        'owner_id',
        'booking_id',
    ];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Member::class, 'owner_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'team_member_pivot', 'team_id', 'member_id')
            ->withPivot(['phone', 'joined'])
            ->withTimestamps();
    }
}
