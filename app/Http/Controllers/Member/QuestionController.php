<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $premium = $request->user()->memberProfile->is_active;

        if (!$premium) {
            return Inertia::render('member/questions/Index', [
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        $conversations = Conversation::where('submitter_id', $request->user()->id)
            ->latest()
            ->paginate(10)
            ->through(function ($conversation) {
                $conversation->title = $conversation->messages()->oldest()->first()?->content;
                $conversation->date = $conversation->created_at->format('d F Y • H:i');

                return $conversation;
            });

        return Inertia::render('member/questions/Index', [
            'conversations' => $conversations,
        ]);
    }

    public function create(Request $request)
    {
        $premium = $request->user()->memberProfile->is_active;

        if (!$premium) {
            return Inertia::render('member/questions/Create', [
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        return Inertia::render('member/questions/Create');
    }

    public function store(Request $request)
    {
        $premium = $request->user()->memberProfile->is_active;
        
        if (!$premium) {
            return back()->withErrors([
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        $messageData = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $conversation = Conversation::create([
            'submitter_id'  => $request->user()->id,
            'ticket_number' => Conversation::max('ticket_number')
                ? Conversation::max('ticket_number') + 1
                : 0,
            'is_closed'     => false,
        ]);

        Message::create([
            'sender_id'         => $request->user()->id,
            'conversation_id'   => $conversation->id,
            'content'           => $messageData['content'],
        ]);

        return redirect()->route('member.questions.show', $conversation->ticket_number);
    }

    public function show(Request $request, string $ticketNumber)
    {
        $premium = $request->user()->memberProfile->is_active;

        if (!$premium) {
            return back()->withErrors([
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        $conversation = Conversation::where('submitter_id', $request->user()->id)
            ->where('ticket_number', $ticketNumber)
            ->with(['messages'])
            ->first();

        if (!$conversation) {
            return Inertia::render('member/questions/Show', [
                'error' => 'Pertanyaan tidak ditemukan.',
            ]);
        }

        $messages = collect($conversation->messages)
            ->map(function ($item) {
                $item->time = $item->created_at->format('H:i');

                return $item;
            })
            ->groupBy(function ($item) {
                return $item->created_at->format('j F Y');
            });

        return Inertia::render('member/questions/Show', [
            'conversation'  => $conversation,
            'messages'      => $messages,
        ]);
    }

    public function send(Request $request, string $ticketNumber)
    {
        $premium = $request->user()->memberProfile->is_active;

        if (!$premium) {
            return back()->withErrors([
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        $messageData = $request->validate([
            'content'           => ['required', 'string'],
        ]);

        $conversation = Conversation::where('submitter_id', $request->user()->id)
            ->where('ticket_number', $ticketNumber)
            ->first();

        if (!$conversation) {
            return back()->withErrors([
                'error' => 'Pertanyaan tidak ditemukan.',
            ]);
        }

        Message::create([
            'sender_id'         => $request->user()->id,
            'conversation_id'   => $conversation->id,
            'content'           => $messageData['content'],
        ]);

        return redirect()->route('member.questions.show', $conversation->ticket_number);
    }
}
