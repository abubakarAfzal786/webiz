<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicketMessage;
use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function index()
    {
        return view('admin.support-chat.index');
    }

    public function list()
    {
        $messages = SupportTicketMessage::query()->where(['user_id' => auth()->id()])->get();
        return response()->json([
            'messages'    => $messages,
        ], 200);
    }
}
