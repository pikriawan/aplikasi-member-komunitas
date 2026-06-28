<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Conversation::with(['submitter', 'submitter.memberProfile'])
            ->search($request->query('q'))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        if ($conversations->count() === 0) {
            Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Percakapan tidak ditemukan.',
                ],
            ]);
        }

        return Inertia::render('Staff/Conversation/Index', [
            'conversations' => $conversations,
            'q' => $request->query('q'),
        ]);
    }

    public function show(Request $request, string $id)
    {
        $conversation = Conversation::with('submitter')->where('id', $id)->first();

        if (!$conversation) {
            return Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Percakapan tidak ditemukan.',
                ],
            ])->render('Staff/Conversation/Show');
        }

        $messages = $conversation
            ->messages()
            ->with('sender')
            ->oldest()
            ->get()
            ->groupBy(fn ($message) => $message->date);

        if ($messages->count() === 0) {
            Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Belum ada pesan.',
                ],
            ]);
        }

        return Inertia::render('Staff/Conversation/Show', [
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function storeMessage(Request $request, string $conversationId)
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $conversation = Conversation::where('id', $conversationId)->first();

        if (!$conversation) {
            abort(404);
        }

        $user = $request->user();

        Message::create([
            'sender_id' => $user->id,
            'conversation_id' => $conversation->id,
            'content' => $validated['message'],
        ]);

        return redirect()->route('staff.conversations.show', $conversationId);
    }
}
