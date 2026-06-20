<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $rules = [
            'telephone' => ['nullable', 'string'],
        ];

        if ($request->filled('old_password') || $request->filled('password')) {
            $rules['old_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()];
        }

        $validated = $request->validate($rules);

        $user = $request->user();

        if (!empty($validated['password'])) {
            $user->password = $request->input('password');
        }

        $user->telephone = $request->input('telephone');
        $user->save();

        return redirect()->route('finance.profile.index');
    }
}
