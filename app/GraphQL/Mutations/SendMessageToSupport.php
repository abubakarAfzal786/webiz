<?php

namespace App\GraphQL\Mutations;

use App\Models\Member;
use App\Models\SupportTicket;

class SendMessageToSupport
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args)
    {
        /** @var Member $member */
        $member = auth()->user();
        $text = $args['text'];
        $ticket_id = $args['ticket_id'] ?? null;

        /** @var SupportTicket $ticket */
        if ($ticket_id) {
            $ticket = $member->support_tickets()->find($ticket_id);
            if (!$ticket) {
                return [
                    'message' => 'Please choose correct ticket',
                    'success' => false,
                ];
            }
            $ticket->messages()->create(['text' => $text]);
            return [
                'message' => 'Message sent',
                'success' => true,
            ];
        } else {
            $ticket = $member->support_tickets()->create();
            $ticket->messages()->create(['text' => $text]);
            return [
                'message' => 'Ticket N' . $ticket->id . ' Successfully Created',
                'success' => true,
            ];
        }
    }
}
