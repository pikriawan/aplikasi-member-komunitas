<?php

namespace App\Http\Controllers\Member;

use App\Enums\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->memberProfile->is_active) {
            return Inertia::flash('messages', [
                [
                    'variant' => 'danger',
                    'text' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
                ],
            ])->render('Member/Content/Index');
        }

        $contents = Content::with('uploader')
            ->byType($request->query('type', ContentType::Video->value))
            ->latest()
            ->paginate(25)
            ->appends($request->query());

        if ($contents->count() === 0) {
            return Inertia::flash('messages', [
                [
                    'variant' => 'warning',
                    'text' => 'Tidak ada konten.'
                ]
            ])->render('Member/Content/Index');
        }

        return Inertia::render('Member/Content/Index', [
            'contents' => $contents,
            'type' => $request->query('type', ContentType::Video->value),
        ]);
    }
}
