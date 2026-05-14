<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return match ($request->user()->role) {
            'member'        => redirect()->route('member.contents'),
            'staff'         => redirect()->route('staff.contents'),
            'finance'       => redirect()->route('finance.payments'),
            'leader'        => redirect()->route('leader.statistics'),
            'super_admin'   => redirect()->route('super_admin.accounts'),
        };
    }
}
