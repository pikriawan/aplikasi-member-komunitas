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

    public function show(Request $request, string $fileUrl)
    {
        $user = $request->user();

        if (!$user->memberProfile->is_active) {
            abort(403);
        }

        try {
            $googleClient = new Client();

            $googleClient->setAuthConfig(
                storage_path('app/google/service-account.json'),
            );

            $googleClient->addScope(Drive::DRIVE_READONLY);

            $token = $googleClient->fetchAccessTokenWithAssertion();

            $accessToken = $token['access_token'];

            $drive = new Drive($googleClient);

            $meta = $drive->files->get($fileUrl, [
                'fields' => 'name,mimeType,size',
                'supportsAllDrives' => true,
            ]);

            $http = new GuzzleClient();

            $response = $http->request(
                'GET',
                "https://www.googleapis.com/drive/v3/files/{$fileUrl}",
                [
                    'query' => [
                        'alt' => 'media',
                        'supportsAllDrives' => true,
                    ],
                    'headers' => [
                        'Authorization' => "Bearer {$accessToken}",
                    ],
                    'stream' => true,
                ]
            );

            return response()->streamDownload(
                function () use ($response) {
                    $body = $response->getBody();

                    while (!$body->eof()) {
                        echo $body->read(1024 * 1024);
                        flush();

                        if (function_exists('ob_flush')) {
                            @ob_flush();
                        }
                    }
                },
                $meta->name,
                [
                    'Content-Type' => $meta->mimeType,
                    'Content-Length' => $meta->size,
                ]
            );
        } catch (GoogleException $e) {
            if ($e->getCode() === 404) {
                abort(404);
            }

            Log::error($e);

            abort(500);
        }
    }
}
