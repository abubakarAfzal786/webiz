<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use Illuminate\Http\JsonResponse;

class SupportController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function tickets()
    {
        $tickets = SupportTicket::query()->with('member')->orderBy('updated_at', 'DESC')->get();
        return response()->json(['tickets' => $tickets, 200]);
    }

    /**
     * @param $ticket_id
     * @return JsonResponse
     */
    public function messages($ticket_id)
    {
        $messages = SupportTicketMessage::query()->where('ticket_id', $ticket_id)->orderBy('updated_at', 'DESC')->get();
        return response()->json(['messages' => $messages], 200);
    }

    /**
     * @return JsonResponse
     */
    public function messagesCount()
    {
        $count = SupportTicketMessage::query()->count();
        return response()->json(['count' => $count], 200);
    }
}
