<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'telephone' => ['required', 'string'],
            'password' => ['required'],
            'confirmPassword' => ['required'],
        ]);

        $existingUser = User::where('email', $userData['email'])->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Email ini sudah dipakai.',
            ]);
        }

        if ($userData['password'] !== $userData['confirmPassword']) {
            return back()->withErrors([
                'password' => 'Password dan konfirmasi password tidak sesuai.',
            ]);
        }

        $userData['role'] = 'member';
        $userData['password'] = Hash::make($userData['password']);
        $userData['is_active'] = true;

        $user = User::create($userData);

        $memberProfile = new MemberProfile();
        $memberProfile->user()->associate($user);
        $memberProfile->expire_date = now();
        $memberProfile->institution = $request->string('institution');
        $memberProfile->department = $request->string('department');
        $memberProfile->address = $request->string('address');
        $memberProfile->is_active = false;
        $memberProfile->save();

        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('member.contents');
    }

    public function noticeVerification(Request $request)
    {
        if ($request->user()->email_verified_at) {
            return redirect()->route('member.contents');
        }

        return Inertia::render('VerifyEmail');
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect()->route('member.contents');
    }

    public function sendVerification(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return Inertia::flash('message', 'Tautan verifikasi baru telah dikirim ke email Anda yang Anda tulis ketika registrasi.')->back();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? Inertia::flash('status', 'Kami telah mengirimi Anda tautan reset password.')->back()
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(string $token)
    {
        return Inertia::render('ResetPassword', ['token' => $token]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
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
