<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
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
            'storageUrl' => rtrim(Storage::url('/'), '/'),
            'setting' => Setting::allAsMap(),
            'user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'memberProfile' => $request->user()?->role === UserRole::Member->value
                ? $request->user()->memberProfile
                : null,
        ]);
    }
}
