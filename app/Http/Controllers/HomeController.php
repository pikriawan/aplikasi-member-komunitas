<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::all()->map(function ($post) {
            $post->date = $post->created_at->format('d/m/Y');

            return $post;
        });

        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }
}
