<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property User|Collection user
 * @property Member|Collection member
 * @property SupportTicketMessage|Collection messages
 */
class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $appends = [
        'support_specialist',
        'last_message',
        'messages_count',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany(SupportTicketMessage::class, 'ticket_id', 'id');
    }

    /**
     * @return String|null
     */
    public function getSupportSpecialistAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    /**
     * @return String|null
     */
    public function getLastMessageAttribute()
    {
        $last = $this->messages()->orderBy('created_at', 'DESC')->first();
        return $last ? $last->text : '';
    }

    /**
     * @return integer
     */
    public function getMessagesCountAttribute()
    {
        return $this->messages->count();
    }
}
