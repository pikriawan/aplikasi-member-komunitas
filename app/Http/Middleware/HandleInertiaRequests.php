<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appUrl' => config('app.url'),
            'storageUrl' => substr(Storage::url('.'), 0, -2),
            'settings' => collect([
                'community_name',
                'community_logo',
                'email',
                'phone_number',
                'x_account_url',
                'facebook_account_url',
                'linkedin_account_url',
                'skype_account_url',
                'instagram_account_url',
                'youtube_account_url',
                'primary_color',
                'surface_color',
                'background_image',
                'hero_title',
                'hero_description',
                'about_image',
                'about_title',
                'about_description',
            ])->mapWithKeys(fn (string $key) => [$key => Setting::get($key)]),
            'auth.user' => fn (Request $request) => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
        ]);
    }
}
