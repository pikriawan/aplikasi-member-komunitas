<?php

namespace App\Http\Controllers\Finance;

use App\Enums\InvoiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\MemberProfile;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['user', 'payment', 'payment.verifier'])
            ->latest()
            ->paginate(10)
            ->appends($request->query('q'));

        if ($invoices->count() === 0) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'info',
                        'text' => 'Tidak ada tagihan.',
                    ],
                ],
            ]);
        }

        return Inertia::render('Finance/Invoice/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Request $request, ?string $id)
    {
        $invoice = Invoice::with('payment')->find($id);

        if (!$invoice) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'danger',
                        'text' => 'Tagihan tidak ditemukan.',
                    ],
                ],
            ]);
        }

        return Inertia::render('Finance/Invoice/Show', [
            'invoice' => $invoice,
        ]);
    }

    public function accept(Request $request, ?string $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            abort(404);
        }

        if ($invoice->status !== InvoiceStatus::Paid->value) {
            abort(400);
        }

        $invoice->status = InvoiceStatus::Verified;
        $invoice->save();

        $payment = $invoice->payment()->first();
        $payment->verifier_id = $request->user()->id;
        $payment->save();

        $memberProfile = MemberProfile::where('user_id', $invoice->user_id)->first();
        $membershipDuration = Carbon::createFromFormat('m', Setting::get('membership_duration', '0'));
        $memberProfile->expired_date = now()->addMonths($membershipDuration->month);
        $memberProfile->save();

        return redirect()->route('finance.invoices.show', $invoice->id);
    }

    public function reject(Request $request, ?string $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            abort(404);
        }

        if ($invoice->status !== InvoiceStatus::Paid->value) {
            abort(400);
        }

        $invoice->status = InvoiceStatus::Rejected;
        $invoice->save();

        $request->validate([
            'reject_reason' => ['nullable', 'string'],
        ]);

        $payment = $invoice->payment()->first();
        $payment->verifier_id = $request->user()->id;
        $payment->reject_reason = $request->input('reject_reason');
        $payment->save();

        return redirect()->route('finance.invoices.show', $invoice->id);
    }
}
