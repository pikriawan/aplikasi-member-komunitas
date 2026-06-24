<?php

namespace App\Http\Controllers\Leader;

use App\Enums\ContentType;
use App\Enums\InvoiceStatus;
use App\Enums\PostCategory;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Invoice;
use App\Models\MemberProfile;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisticController extends Controller
{
    public function index()
    {
        $result = MemberProfile::select('created_at', 'expired_date')->get();

        $now = now();
        $months = collect(range(11, 0))->map(fn ($i) => $now->copy()->subMonths($i));

        $memberProfiles = [
            'labels' => $months->map(fn ($month) => $month->format('i/Y')),
            'datasets' => [
                [
                    'label' => 'Aktif',
                    'data' => $months->map(function ($month) use ($now, $result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('expired_date', '>=', $now)
                            ->count();
                    }),
                    'borderColor' => '#03C93E',
                    'backgroundColor' => '#36FC71',
                ],
                [
                    'label' => 'Nonaktif',
                    'data' => $months->map(function ($month) use ($now, $result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('expired_date', '<', $now)
                            ->count();
                    }),
                    'borderColor' => '#FF0900',
                    'backgroundColor' => '#FF6B66',
                ],
            ],
        ];

        $result = Content::select('created_at', 'type')->get();

        $contents = [
            'labels' => $months->map(fn ($month) => $month->format('i/Y')),
            'datasets' => [
                [
                    'label' => 'Video',
                    'data' => $months->map(function ($month) use ($result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('type', ContentType::Video->value)
                            ->count();
                    }),
                    'borderColor' => '#03C93E',
                    'backgroundColor' => '#36FC71',
                ],
                [
                    'label' => 'Ebook',
                    'data' => $months->map(function ($month) use ($result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('type', ContentType::Ebook->value)
                            ->count();
                    }),
                    'borderColor' => '#FF0900',
                    'backgroundColor' => '#FF6B66',
                ],
            ],
        ];

        $result = Post::select('created_at', 'category')->get();

        $posts = [
            'labels' => $months->map(fn ($month) => $month->format('i/Y')),
            'datasets' => [
                [
                    'label' => 'Berita',
                    'data' => $months->map(function ($month) use ($result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('category', PostCategory::News->value)
                            ->count();
                    }),
                    'borderColor' => '#03C93E',
                    'backgroundColor' => '#36FC71',
                ],
                [
                    'label' => 'Acara',
                    'data' => $months->map(function ($month) use ($result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('category', PostCategory::Event->value)
                            ->count();
                    }),
                    'borderColor' => '#FF0900',
                    'backgroundColor' => '#FF6B66',
                ],
            ],
        ];

        $result = Invoice::select('created_at', 'amount', 'due_date', 'status')->get();

        $invoices = [
            'labels' => $months->map(fn ($month) => $month->format('i/Y')),
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $months->map(function ($month) use ($result) {
                        return $result
                            ->where('created_at', '>=', $month->copy()->firstOfMonth())
                            ->where('created_at', '<=', $month->copy()->lastOfMonth())
                            ->where('status', InvoiceStatus::Verified->value)
                            ->reduce(function (?float $carry, $invoice) {
                                return $carry + $invoice->amount;
                            }, 0);
                    }),
                    'borderColor' => '#03C93E',
                    'backgroundColor' => '#36FC71',
                ],
            ],
        ];

        return Inertia::render('Leader/Statistic/Index', [
            'memberProfiles' => $memberProfiles,
            'contents' => $contents,
            'posts' => $posts,
            'invoices' => $invoices,
        ]);
    }

    public function indexMembers(Request $request)
    {
        $memberProfiles = MemberProfile::with('user')
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        if ($memberProfiles->count() === 0) {
            Inertia::flash([
                'messages' => [
                    [
                        'variant' => 'info',
                        'text' => 'Tidak ada member.',
                    ],
                ],
            ]);
        }

        return Inertia::render('Leader/Statistic/Member/Index', [
            'memberProfiles' => $memberProfiles,
        ]);
    }
}
