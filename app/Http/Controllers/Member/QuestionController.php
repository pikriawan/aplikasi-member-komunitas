<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $premium = $request->user()?->memberProfile?->is_active;

        if (!$premium) {
            return Inertia::render('member/Contents', [
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

        return Inertia::render('member/Questions', [
            'conversations' => $conversations,
        ]);
    }
}
