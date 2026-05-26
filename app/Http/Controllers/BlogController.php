<?php

namespace App\Http\Controllers;

use App\Enums\PostCategory;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::byCategory($request->query('category'))
            ->latest()
            ->paginate(10)
            ->appends($request->query())
            ->through(fn ($post) => [
                ...$post->toArray(),
                'date' => $post->created_at->timezone(config('app.timezone'))->format('d/m/Y'),
            ]);

        return Inertia::render('Blog', [
            'posts' => $posts,
            'category' => $request->query('category', ''),
        ]);
    }

    public function search(Request $request)
    {
        $posts = Post::search($request->query('q'))
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return Inertia::render('BlogSearch', [
            'posts' => $posts,
            'q' => $request->query('q'),
        ]);
    }

    public function show(string $slug)
    {
        $foundPost = Post::with('author')->where('slug', $slug)->first();

        $post = $foundPost
            ? [
                ...$foundPost->toArray(),
                'date' => $foundPost->created_at->timezone(config('app.timezone'))->format('d/m/Y H:i'),
            ]
            : null;

        return Inertia::render('Post', [
            'post' => $post,
        ]);
    }
}
