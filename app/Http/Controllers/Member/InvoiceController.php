<?php

namespace App\Http\Controllers\Member;

use App\Enums\InvoiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        $user = $request->user();
        $invoice = $user->invoices()
            ->with('payment')
            ->where('id', $id)
            ->first();

        if (!$invoice) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'danger',
                        'text' => 'Tagihan tidak ditemukan.',
                    ],
                ],
            ]);
        } else if ($invoice->status === InvoiceStatus::Unpaid->value) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'info',
                        'text' => "Silahkan lakukan transfer ke rekening tujuan dengan jumlah yang ditentukan, lalu unggah bukti pembayaran sebelum {$invoice->due_date}.",
                    ],
                ],
            ]);
        } else if ($invoice->status === InvoiceStatus::Paid->value) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'info',
                        'text' => 'Silahkan tunggu verifikasi dari petugas keuangan.',
                    ],
                ],
            ]);
        } else if ($invoice->status === InvoiceStatus::Verified->value) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'success',
                        'text' => 'Pembayaran telah berhasil diverifikasi.',
                    ],
                ],
            ]);
        }

        return Inertia::render('Member/Invoice/Show', [
            'invoice' => $invoice,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->memberProfile->is_active) {
            return redirect()->route('member.invoices.index');
        }

        $pendingInvoice = $user->invoices()
            ->where('due_date', '>', now())
            ->where('status', InvoiceStatus::Unpaid)
            ->orWhere('status', InvoiceStatus::Paid)
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

        Payment::create([
            'invoice_id' => $invoice->id,
            'payer_id' => $user->id,
        ]);

        return redirect()->route('member.invoices.show', $invoice->id);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $invoice = $user->invoices()
            ->with('payment')
            ->where('id', $id)
            ->first();

        if (!$invoice) {
            abort(404);
        }

        $request->validate([
            'payment_proof'         => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'date'                  => ['required', 'date_format:Y-m-d\TH:i'],
            'account_holder_name'   => ['required', 'string'],
            'account_number'        => ['required', 'string'],
            'account_bank_name'     => ['required', 'string'],
        ]);

        $invoice->payment->payment_proof_url = $request->file('payment_proof')->store();
        $invoice->payment->date = $request->input('date');
        $invoice->payment->account_holder_name = $request->input('account_holder_name');
        $invoice->payment->account_number = $request->input('account_number');
        $invoice->payment->account_bank_name = $request->input('account_bank_name');
        $invoice->payment->save();

        $invoice->status = InvoiceStatus::Paid;
        $invoice->save();

        return redirect()->route('member.invoices.show', $invoice->id);
    }

    public function cancel(Request $request, string $id)
    {
        $user = $request->user();
        $invoice = $user->invoices()->where('id', $id)->first();

        if (!$invoice) {
            abort(404);
        }

        if ($invoice->status === InvoiceStatus::Paid->value) {
            abort(400);
        }

        $invoice->status = InvoiceStatus::Canceled;
        $invoice->save();

        return redirect()->route('member.invoices.show', $invoice->id);
    }
}
