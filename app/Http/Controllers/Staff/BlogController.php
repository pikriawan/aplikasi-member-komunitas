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

        if ($posts->count() === 0) {
            Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Tidak ada postingan.'
                ]
            ]);
        }

        return Inertia::render('Staff/Blog/Index', [
            'posts' => $posts,
            'q' => $request->query('q'),
        ]);
    }

    public function generateUniqueSlug(string $title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
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
            'slug' => $this->generateUniqueSlug($request->input('title')),
            'category' => $request->input('category'),
            'summary' => $request->input('summary', ''),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('staff.posts.index');
    }

    public function edit(Request $request, string $id)
    {
        $user = $request->user();
        $post = $user->posts()->where('id', $id)->first();

        if (!$post) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'danger',
                        'text' => 'Postingan tidak ditemukan.',
                    ]
                ]
            ]);
        }

        return Inertia::render('Staff/Blog/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $post = $user->posts()->where('id', $id)->first();

        if (!$post) {
            abort(404);
        }

        $request->validate([
            'title' => ['required', 'string'],
            'category' => ['required', new Enum(PostCategory::class)],
            'summary' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);

        if ($post->title !== $request->input('title')) {
            $post->title = $request->input('title');
            $post->slug = $this->generateUniqueSlug($request->input('title'));
        }

        $post->category = $request->input('category');
        $post->summary = $request->input('summary');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('staff.posts.index');
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $post = $user->posts()->where('id', $id)->first();

        if (!$post) {
            abort(404);
        }

        $post->delete();

        return redirect()->route('staff.posts.index');
    }
}
