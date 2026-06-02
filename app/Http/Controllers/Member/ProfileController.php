<?php

namespace App\Http\Controllers\Member;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $foundMemberProfile = $request->user()->memberProfile;

        $memberProfile = [
            ...$foundMemberProfile->toArray(),
            'id' => Str::padLeft($foundMemberProfile->id, 5, '0'),
            'join_date' => $foundMemberProfile->created_at->timezone(config('app.timezone'))->format('d F Y'),
            'membership_until' => $foundMemberProfile->expired_date->timezone(config('app.timezone'))->format('d F Y'),
        ];

        $leaderName = User::where('role', UserRole::Leader->value)->first()?->name;

        return Inertia::render('Member/Profile/Show', [
            'memberProfile' => $memberProfile,
            'leaderName' => $leaderName,
        ]);
    }
}
