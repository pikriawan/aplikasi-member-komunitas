<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $posts = Post::with(['category', 'author'])
            ->byCategory($categorySlug)
            ->latest('created_at')
            ->paginate(10)
            ->appends($request->query())
            ->through(function ($post) {
                $post->date = $post->created_at->format('d/m/Y');

                return $post;
            });

        $categories = Category::all()
            ->map(function ($category) use ($categorySlug) {
                $category->active = $category->slug === $categorySlug;

                return $category;
            })
            ->prepend([
                'name' => 'Semua',
                'slug' => '',
                'active' => !$categorySlug,
            ]);

        return Inertia::render('Blog', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->date = $post->created_at->format('d/m/Y');

        $categories = Category::all()->prepend([
            'name' => 'Semua',
            'slug' => '',
        ]);

        return Inertia::render('Post', [
            'post' => $post->load(['category', 'author']),
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->query('q');

        $posts = Post::search($search)->latest()->paginate(10);

        return Inertia::render('BlogSearch', [
            'posts' => $posts,
        ]);
    }
}
