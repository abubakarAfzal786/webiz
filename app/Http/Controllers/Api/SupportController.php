<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function tickets()
    {
        $tickets = SupportTicket::query()
            ->with('member')
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json(['tickets' => $tickets, 200]);
    }

    /**
     * @param $ticket_id
     * @return JsonResponse
     */
    public function messages($ticket_id)
    {
        $messages = SupportTicketMessage::query()
            ->where('ticket_id', $ticket_id)
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json(['messages' => $messages], 200);
    }

    /**
     * @return JsonResponse
     */
    public function messagesCount()
    {
        $count = SupportTicketMessage::query()
            ->where('is_member', true)
            ->where('seen', false)
            ->count();

        return response()->json(['count' => $count], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $ticket_id = $request->get('ticket_id');

        SupportTicketMessage::query()
            ->where('ticket_id', $ticket_id)
            ->where('is_member', true)
            ->where('seen', false)
            ->update(['seen' => true]);

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function messageSend(Request $request)
    {
        $ticket_id = $request->get('ticket_id');
        $message = $request->get('message');

        $ticketMessage = SupportTicketMessage::query()->create([
            'ticket_id' => $ticket_id,
            'text' => $message,
            'is_member' => false,
        ]);

        return response()->json(['message' => $ticketMessage], 200);
    }
}
