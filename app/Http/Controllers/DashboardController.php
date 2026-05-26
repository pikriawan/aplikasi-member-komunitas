<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        switch ($request->user()->role) {
            case UserRole::Member->value:
                return redirect()->route('member.contents.index');
            case UserRole::Staff->value:
                return redirect()->route('staff.contents.index');
            case UserRole::Finance->value:
                return redirect()->route('finance.payments.index');
            case UserRole::Leader->value:
                return redirect()->route('leader.statistics.index');
            case UserRole::SuperAdmin->value:
                return redirect()->route('super_admin.accounts.index');
        }
    }
}
