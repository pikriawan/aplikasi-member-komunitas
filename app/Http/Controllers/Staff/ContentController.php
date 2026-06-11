<?php

namespace App\Http\Controllers\Staff;

use App\Enums\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
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
}
