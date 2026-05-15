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
        $premium = $request->user()?->memberProfile?->is_active;

        if (!$premium) {
            return Inertia::render('member/Contents', [
                'error' => 'Anda perlu berlangganan member premium untuk mengakses fitur ini.',
            ]);
        }

        $type = $request->query('type', 'video');

        $contents = Content::byType($type)
            ->paginate(10)
            ->through(function ($content) {
                $content->date = $content->created_at->format('d F Y • H:i');

                return $content;
            });

        return Inertia::render('member/Contents', [
            'contents' => $contents,
        ]);
    }
}
