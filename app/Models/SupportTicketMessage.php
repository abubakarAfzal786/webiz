<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property SupportTicket|Collection ticket
 * @property boolean is_member
 */
class SupportTicketMessage extends Model
{
    protected $fillable = [
        'ticket_id',
        'text',
        'is_member',
        'seen',
    ];

    protected $casts = [
        'is_member' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id', 'id');
    }

    /**
     * @return Collection|null
     */
    public function member()
    {
        return $this->is_member ? $this->ticket->member : null;
    }

    /**
     * @return Collection|null
     */
    public function user()
    {
        return $this->is_member ? null : $this->ticket->user;
    }
}
