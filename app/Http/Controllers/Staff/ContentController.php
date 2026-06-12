<?php

namespace App\Http\Controllers\Staff;

use App\Enums\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $contents = Content::with('uploader')
            ->byType($request->query('type', ContentType::Video->value))
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        if ($contents->count() === 0) {
            return Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Tidak ada konten.'
                ]
            ])->render('Staff/Content/Index');
        }

        return Inertia::render('Staff/Content/Index', [
            'contents' => $contents,
            'type' => $request->query('type', ContentType::Video->value),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => ['required', 'string'],
            'type' => ['required', new Enum(ContentType::class)],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_thumbnail' => ['nullable', 'string'],
        ];

        if ($request->input('type') === ContentType::Video->value) {
            $rules['file'] = ['required', 'file', 'mimes:mov,mp4,webm', 'max:10240'];
        } else {
            $rules['file'] = ['required', 'file', 'mimes:pdf', 'max:10240'];
        }

        $request->validate($rules);

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

        $content->file_url = $request->file('file')->store();
        $content->save();

        return redirect()->route('staff.contents.index');
    }
}
