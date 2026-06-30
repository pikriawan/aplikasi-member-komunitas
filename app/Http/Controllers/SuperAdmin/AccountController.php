<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = User::latest()
            ->paginate(10)
            ->appends($request->query());

        if ($accounts->count() === 0) {
            Inertia::flash('messages', [
                [
                    'variant' => 'info',
                    'text' => 'Tidak ada akun.',
                ],
            ]);
        }

        return Inertia::render('SuperAdmin/Account/Index', [
            'accounts' => $accounts,
        ]);
    }

    public function show(Request $request, string $id)
    {
        $account = User::with('memberProfile')->find($id);

        if (!$account) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'danger',
                        'text' => 'Akun tidak ditemukan.',
                    ],
                ],
            ]);
        }

        return Inertia::render('SuperAdmin/Account/Show', [
            'account' => $account,
        ]);
    }

    public function updateStatus(Request $request, string $id)
    {
        $account = User::find($id);

        if (!$account) {
            abort(404);
        }

        $request->validate([
            'status' => ['required', 'string'],
        ]);

        if ($account->role === UserRole::SuperAdmin->value) {
            return back()->withErrors([
                'status' => 'Tidak bisa mengubah status akun dengan role super admin.'
            ])->onlyInput('status');
        }

        $account->is_active = $request->boolean('status');
        $account->save();

        return redirect()->route('super_admin.accounts.show', $id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'telephone' => ['nullable', 'string'],
            'role' => ['required', new Enum(UserRole::class)],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()]
        ]);

        $existingUser = User::where('email', $validated['email'])->first();

        if ($existingUser) {
            return back()->withErrors([
                'email' => 'Email ini sudah dipakai.'
            ])->onlyInput('email');
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_active' => true,
            'password' => $request->input('password'),
            'role' => $request->input('role'),
            'telephone' => $request->input('telephone'),
        ]);

        $user->markEmailAsVerified();

        return redirect()->route('super_admin.accounts.index');
    }
}
