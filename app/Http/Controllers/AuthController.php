<?php

namespace App\Http\Controllers;

use App\Enums\MemberGender;
use App\Enums\UserRole;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string'],
            'email'     => ['required', 'email'],
            'password'  => ['required', 'confirmed', RulesPassword::min(8)->numbers()],
        ]);

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Email ini sudah dipakai.'
            ])->onlyInput('email');
        }

        $data['role'] = UserRole::Member;
        $data['telephone'] = $request->input('telephone');
        $data['is_active'] = true;

        $user = User::create($data);

        MemberProfile::create([
            'user_id'           => $user->id,
            'expired_date'      => now(),
            'gender'            => $request->input('gender'),
            'blood_type'        => $request->input('blood_type'),
            'last_education'    => $request->input('last_education'),
            'institution'       => $request->input('institution'),
            'department'        => $request->input('department'),
            'address'           => $request->input('address'),
            'is_active'         => false,
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

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? Inertia::flash(['status' => __($status)])->back()
            : back()->withErrors(['email' => __($status)]);
    }

    public function showPasswordReset(Request $request, string $token)
    {
        return Inertia::render('ResetPassword', [
            'request' => $request,
            'token' => $token,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'     => ['required'],
            'email'     => ['required', 'email'],
            'password'  => ['required', 'confirmed', RulesPassword::min(8)->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
