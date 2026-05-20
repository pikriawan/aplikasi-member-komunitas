<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string'],
            'email'         => ['required', 'email'],
            'telephone'     => ['required', 'string'],
            'password'      => ['required', 'confirmed'],
        ]);

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Email ini sudah dipakai.'
            ])->onlyInput('email');
        }

        $data['role'] = UserRole::Member;
        $data['is_active'] = true;

        $user = User::create($data);

        MemberProfile::create([
            'user_id'       => $user->id,
            'expired_date'  => now(),
            'institution'   => $request->string('institution'),
            'department'    => $request->string('department'),
            'address'       => $request->string('address'),
            'is_active'     => false,
        ]);

        Auth::login($user);

        event(new Registered($user));

        return redirect()->intended(route('dashboard'));
    }

    public function sendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('VerifyEmail');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->intended(route('dashboard'));
    }

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return Inertia::flash('message', 'Verification link sent!')->back();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
