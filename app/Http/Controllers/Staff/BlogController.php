<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $posts = $user->posts()
            ->search($request->query('q'))
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return Inertia::render('Staff/Blog/Index', [
            'posts' => $posts,
            'q' => $request->query('q'),
        ]);
    }
}
