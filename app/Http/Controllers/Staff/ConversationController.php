<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with('submitter')
            ->latest()
            ->paginate(20);

        return Inertia::render('Staff/Conversation/Index', [
            'conversations' => $conversations,
        ]);
    }
}
