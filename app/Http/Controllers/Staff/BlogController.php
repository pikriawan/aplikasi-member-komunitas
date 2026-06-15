<?php

namespace App\Http\Controllers\Staff;

use App\Enums\PostCategory;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'category' => ['required', new Enum(PostCategory::class)],
            'summary' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);

        $user = $request->user();

        Post::create([
            'author_id' => $user->id,
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'category' => $request->input('category'),
            'summary' => $request->input('summary', ''),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('staff.posts.index');
    }
}
