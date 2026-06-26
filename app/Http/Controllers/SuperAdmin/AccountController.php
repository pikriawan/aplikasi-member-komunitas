<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
}
