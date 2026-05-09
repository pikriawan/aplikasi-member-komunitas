<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'telephone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $existingUser = User::where('email', $userData['email'])->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Email ini sudah dipakai.',
            ]);
        }

        $userData['role'] = 'member';
        $userData['password'] = Hash::make($userData['password']);
        $userData['is_active'] = true;

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
