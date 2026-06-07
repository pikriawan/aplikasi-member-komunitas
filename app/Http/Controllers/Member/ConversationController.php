<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Member/Conversation/Index');
    }
}
