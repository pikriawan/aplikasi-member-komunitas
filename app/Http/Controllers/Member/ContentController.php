<?php

namespace App\Http\Controllers\Member;

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
            return Inertia::flash('alerts', [
                [
                    'variant' => 'danger',
                    'text' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
                ],
            ])->render('Member/Content/Index');
        }

        $contents = Content::with('uploader')->latest()->get();

        if ($contents->count() === 0) {
            return Inertia::flash('alerts', [
                [
                    'variant' => 'warning',
                    'text' => 'Tidak ada konten.'
                ]
            ])->render('Member/Content/Index');
        }

        return Inertia::render('Member/Content/Index', [
            'contents' => $contents,
        ]);
    }
}
