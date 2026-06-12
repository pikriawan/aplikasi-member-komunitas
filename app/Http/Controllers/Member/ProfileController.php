<?php

namespace App\Http\Controllers\Member;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $memberProfile = $request->user()->memberProfile;

        $leaderName = User::where('role', UserRole::Leader->value)->first()?->name;

        return Inertia::render('Member/Profile/Index', [
            'memberProfile' => $memberProfile,
            'leaderName' => $leaderName,
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'profile_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'delete_profile_image'  => ['nullable', 'string'],
            'telephone'             => ['nullable', 'string'],
            'gender'                => ['nullable', 'string', 'in:Laki-laki,Perempuan'],
            'blood_type'            => ['nullable', 'string', 'in:A,B,AB,O'],
            'last_education'        => ['nullable', 'string'],
            'institution'           => ['nullable', 'string'],
            'department'            => ['nullable', 'string'],
            'address'               => ['nullable', 'string'],
        ];

        if ($request->filled('old_password') || $request->filled('password')) {
            $rules['old_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()];
        }

        $validated = $request->validate($rules);

        $user = $request->user();
        $memberProfile = $user->memberProfile;

        if ($request->boolean('delete_profile_image')) {
            $memberProfile->image_url = null;
        } else if (!empty($validated['profile_image'])) {
            $memberProfile->image_url = $request->file('profile_image')->store();
        }

        $memberProfile->gender = $request->input('gender');
        $memberProfile->blood_type = $request->input('blood_type');
        $memberProfile->last_education = $request->input('last_education');
        $memberProfile->institution = $request->input('institution');
        $memberProfile->department = $request->input('department');
        $memberProfile->address = $request->input('address');
        $memberProfile->save();

        if (!empty($validated['password'])) {
            $user->password = $request->input('password');
        }

        $user->telephone = $request->input('telephone');
        $user->save();

        return redirect()->route('member.profile.index');
    }
}
