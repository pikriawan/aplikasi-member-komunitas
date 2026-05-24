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

        $categories = array_map(function ($category) use ($request) {
            return [
                ...$category,
                'active' => $category['value'] === $request->query('category', ''),
            ];
        }, [
            [
                'name' => 'All',
                'value' => '',
                'label' => 'Semua',
            ],
            ...array_map(function ($category) {
                return [
                    'name' => $category->name,
                    'value' => $category->value,
                    'label' => $category->label(),
                ];
            }, PostCategory::cases()),
        ]);

        return Inertia::render('Blog', [
            'posts' => $posts,
            'categories' => $categories,
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
}
