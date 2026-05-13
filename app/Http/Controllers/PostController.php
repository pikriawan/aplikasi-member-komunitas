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

        $posts = Post::with(['categories', 'author'])
            ->byCategory($categorySlug)
            ->latest('created_at')
            ->paginate(5)
            ->through(function ($post) {
                return [
                    'id'            => $post->id,
                    'date'          => $post->created_at->format('d/m/Y'),
                    'title'         => $post->title,
                    'description'   => $post->description,
                ];
            });

        return Inertia::render('Blog', [
            'posts' => $posts,
            'categories' => Category::all(),
            'selectedCategory' => $request->query('category'),
        ]);
    }
}
