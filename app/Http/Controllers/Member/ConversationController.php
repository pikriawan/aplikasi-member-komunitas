<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->memberProfile->is_active) {
            return Inertia::flash('messages', [
                [
                    'variant' => 'danger',
                    'text' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
                ],
            ])->render('Member/Conversation/Index');
        }

        $messages = $request->user()
            ->conversation
            ->messages()
            ->with('sender')
            ->oldest()
            ->get()
            ->groupBy(fn ($message) => $message->date);

        return Inertia::render('Member/Conversation/Index', [
            'messages' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->memberProfile->is_active) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $conversation = $request->user()->conversation;

        Message::create([
            'sender_id' => $user->id,
            'conversation_id' => $conversation->id,
            'content' => $validated['message'],
        ]);

        return redirect()->route('member.conversation.index');
    }
}
