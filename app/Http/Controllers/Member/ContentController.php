<?php

namespace App\Http\Controllers\Member;

use App\Enums\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Exception as GoogleException;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            ->paginate(30)
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

    public function show(Request $request, string $fileUrl)
    {
        $user = $request->user();

        if (!$user->memberProfile->is_active) {
            abort(403);
        }

        abort(404);
    }
}
