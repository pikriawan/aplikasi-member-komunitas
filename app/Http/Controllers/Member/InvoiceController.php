<?php

namespace App\Http\Controllers\Member;

use App\Enums\InvoiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->invoices->count() === 0) {
            return Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'info',
                        'text' => 'Tidak ada tagihan.'
                    ]
                ]
            ])->render('Member/Invoice/Index');
        }

        $invoices = $user->invoices()->latest()->paginate(10);

        return Inertia::render('Member/Invoice/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Request $request, string $id)
    {
        return Inertia::render('Member/Invoice/Show');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->memberProfile->is_active) {
            return redirect()->route('member.invoices.index');
        }

        $pendingInvoice = $user->invoices()
            ->where('status', InvoiceStatus::Unpaid)
            ->where('due_date', '>', now())
            ->first();

        if ($pendingInvoice) {
            return redirect()->route('member.invoices.show', $pendingInvoice->id);
        }

        $invoice = Invoice::create([
            'user_id' => $user->id,
            'amount' => (float) Setting::get('membership_fee', '0'),
            'due_date' => now()->addHours((float) Setting::get('invoice_countdown', 24)),
            'status' => InvoiceStatus::Unpaid,
        ]);

        return redirect()->route('member.invoices.show', $invoice->id);
    }
}
