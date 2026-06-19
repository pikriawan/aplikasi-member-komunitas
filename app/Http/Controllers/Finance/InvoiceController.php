<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
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
                        'text' => 'Tidak ada tagihan.'
                    ]
                ]
            ]);
        }

        return Inertia::render('Finance/Invoice/Index', [
            'invoices' => $invoices,
        ]);
    }
}
