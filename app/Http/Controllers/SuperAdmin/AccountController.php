<?php

namespace App\Http\Controllers\SuperAdmin;

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
}
