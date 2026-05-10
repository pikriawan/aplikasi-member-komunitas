<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('dashboard');
    }

    public function noticeVerification(Request $request)
    {
        if ($request->user()->email_verified_at) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('VerifyEmail');
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect()->route('dashboard');
    }

    public function sendVerification(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return Inertia::flash('message', 'Email verifikasi berhasil dikirim.')->back();
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
