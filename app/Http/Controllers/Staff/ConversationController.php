<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
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
                    'text' => 'Percakapan tidak ditemukan.'
                ]
            ]);
        }

        return Inertia::render('Staff/Conversation/Index', [
            'conversations' => $conversations,
            'q' => $request->query('q'),
        ]);
    }
}
