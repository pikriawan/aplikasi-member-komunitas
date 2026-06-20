<?php

namespace App\Http\Controllers\Staff;

use App\Enums\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $contents = $user->contents()
            ->search($request->query('q'))
            ->byType($request->query('type', ContentType::Video->value))
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        if ($contents->count() === 0) {
            Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Tidak ada konten.',
                ],
            ]);
        }

        return Inertia::render('Staff/Content/Index', [
            'contents' => $contents,
            'type' => $request->query('type', ContentType::Video->value),
            'q' => $request->query('q'),
        ]);
    }

    public function store(Request $request)
    {
        $isVideo = $request->input('type') === ContentType::Video->value;

        $request->validate([
            'title'             => ['required', 'string'],
            'type'              => ['required', new Enum(ContentType::class)],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_thumbnail'  => ['nullable', 'string'],
            'file'              => [
                'required',
                'file',
                $isVideo ? 'mimes:mov,mp4,webm' : 'mimes:pdf',
                'max:10240',
            ],
        ]);

        $content = new Content();

        $user = $request->user();

        $content->uploader_id = $user->id;

        if ($request->boolean('delete_thumbnail')) {
            $content->thumbnail_url = null;
        }

        $content->title = $request->input('title');
        $content->type = $request->input('type');

        if ($request->hasFile('thumbnail')) {
            $content->thumbnail_url = $request->file('thumbnail')->store();
        }

        $content->file_url = $request->file('file')->store('', app()->isProduction() ? 's3-private' : 'local');
        $content->save();

        return redirect()->route('staff.contents.index', [
            'type' => $content->type,
        ]);
    }

    public function edit(Request $request, string $id)
    {
        $user = $request->user();
        $content = $user->contents()->where('id', $id)->first();

        if (!$content) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'danger',
                        'text' => 'Konten tidak ditemukan.',
                    ],
                ],
            ]);
        }

        return Inertia::render('Staff/Content/Edit', [
            'content' => $content,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $content = $user->contents()->where('id', $id)->first();

        if (!$content) {
            abort(404);
        }

        $isVideo = $request->input('type') === ContentType::Video->value;
        $typeChanged = $request->input('type') !== $content->type;

        $request->validate([
            'title'             => ['required', 'string'],
            'type'              => ['required', new Enum(ContentType::class)],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_thumbnail'  => ['nullable', 'string'],
            'file'              => [
                Rule::requiredIf($typeChanged && !$request->hasFile('file')),
                'nullable',
                $isVideo ? 'mimes:mov,mp4,webm' : 'mimes:pdf',
                'max:10240',
            ],
        ]);

        if ($request->boolean('delete_thumbnail')) {
            $content->thumbnail_url = null;
        } else if ($request->hasFile('thumbnail')) {
            $content->thumbnail_url = $request->file('thumbnail')->store();
        }

        if ($request->hasFile('file')) {
            $content->file_url = $request->file('file')->store('', app()->isProduction() ? 's3-private' : 'local');
        }

        $content->title = $request->input('title');
        $content->type = $request->input('type');
        $content->save();

        return redirect()->route('staff.contents.index', [
            'type' => $content->type,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $content = $user->contents()->where('id', $id)->first();

        if (!$content) {
            abort(404);
        }

        $content->delete();

        return redirect()->route('staff.contents.index');
    }
}
