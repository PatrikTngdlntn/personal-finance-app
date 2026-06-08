<x-app-layout title="Dashboard">
    @php
        $formatRupiah = fn($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $shortRupiah = function ($value) {
            $value = (float) $value;

            if ($value >= 1000000) {
                return number_format($value / 1000000, 1, ',', '.') . ' jt';
            }

            if ($value >= 1000) {
                return number_format($value / 1000, 0, ',', '.') . ' rb';
            }

            return number_format($value, 0, ',', '.');
        };

        $savingGoalProgress = (int) round($savings->avg('progress') ?? 0);
        $completedSavings = $savings->filter(fn($saving) => $saving->target_amount > 0 && $saving->saved_amount >= $saving->target_amount)->count();
        $categoryColors = ['#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6', '#ef4444', '#94a3b8'];
        $categoryTotalAmount = max((float) $categoryTotals->sum(), 1);
        $firstName = explode(' ', trim(auth()->user()->name))[0] ?: auth()->user()->name;
    @endphp

    <div class="space-y-4">
        <header class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-normal text-slate-950 sm:text-3xl">
                    Halo, {{ $firstName }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">Ringkasan keuanganmu hari ini.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm">
                    <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                    {{ now()->translatedFormat('d M Y') }}
                </button>

                <button type="button"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path d="M7 10l5 5 5-5" />
                        <path d="M12 15V3" />
                    </svg>
                    Export
                </button>
            </div>
        </header>

        <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 7V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-1" />
                            <path d="M16 12h6v5h-6a2.5 2.5 0 0 1 0-5Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Total Balance</p>
                        <p class="mt-1 text-2xl font-bold text-slate-950">{{ $formatRupiah($totalBalance) }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-emerald-600">
                    <span class="font-semibold">{{ $wallets->count() }}</span>
                    <span class="text-slate-500">wallet aktif</span>
                </p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m3 17 6-6 4 4 7-7" />
                            <path d="M14 8h6v6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Income Bulan Ini</p>
                        <p class="mt-1 text-2xl font-bold text-slate-950">{{ $formatRupiah($income) }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm {{ $incomeTrend >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    {{ $incomeTrend >= 0 ? '+' : '' }}{{ number_format($incomeTrend, 1, ',', '.') }}%
                    <span class="text-slate-500">dari bulan lalu</span>
                </p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-red-50 text-red-500">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m3 7 6 6 4-4 7 7" />
                            <path d="M14 16h6v-6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Expense Bulan Ini</p>
                        <p class="mt-1 text-2xl font-bold text-slate-950">{{ $formatRupiah($expense) }}</p>
                    </div>
                </div>
                <p class="mt-4 text-sm {{ $expenseTrend <= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    {{ $expenseTrend > 0 ? '+' : '' }}{{ number_format($expenseTrend, 1, ',', '.') }}%
                    <span class="text-slate-500">dari bulan lalu</span>
                </p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <circle cx="12" cy="12" r="5" />
                            <path d="m15 9 4-4" />
                            <path d="M15 5h4v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Saving Goal</p>
                        <p class="mt-1 text-2xl font-bold text-slate-950">{{ $savingGoalProgress }}%</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="mb-2 flex justify-between text-sm text-slate-500">
                        <span>{{ $completedSavings }} dari {{ $savings->count() }} goal tercapai</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-200">
                        <div class="h-2 rounded-full bg-violet-600" style="width: {{ min($savingGoalProgress, 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 xl:grid-cols-10">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm xl:col-span-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Cash Flow 6 Bulan Terakhir</h2>
                        <p class="text-sm text-slate-500">Perbandingan Income vs Expense</p>
                    </div>
                    <button type="button"
                        class="hidden rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 sm:inline-flex">
                        6 Bulan Terakhir
                    </button>
                </div>
                <div class="h-64">
                    <canvas id="cashflowChart"></canvas>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm xl:col-span-5">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-slate-950">Pengeluaran per Kategori</h2>
                    <p class="text-sm text-slate-500">Bulan Ini</p>
                </div>

                <div class="grid gap-5 md:grid-cols-[240px_1fr] md:items-center">
                    <div class="relative mx-auto h-56 w-56">
                        <canvas id="categoryChart"></canvas>
                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-base text-slate-600">Total</span>
                            <span class="mt-1 text-lg font-bold text-slate-950">{{ $formatRupiah($expense) }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($expenseByCategory->take(6) as $index => $item)
                            @php
                                $percentage = ((float) $item->total / $categoryTotalAmount) * 100;
                                $color = $categoryColors[$index % count($categoryColors)];
                            @endphp
                            <div class="grid grid-cols-[1fr_auto_auto] items-center gap-3 text-sm">
                                <div class="flex min-w-0 items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: {{ $color }}"></span>
                                    <span class="truncate text-slate-700">{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                                </div>
                                <span class="text-right font-medium text-slate-800">{{ $formatRupiah($item->total) }}</span>
                                <span class="w-12 text-right text-slate-700">{{ number_format($percentage, 1, ',', '.') }}%</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada pengeluaran bulan ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-950">Transaksi Terbaru</h2>
                    <a href="{{ route('user.transaction.index') }}"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        Lihat Semua
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentTransactions->take(5) as $trx)
                        @php
                            $isIncome = $trx->type === 'income';
                            $isTransfer = $trx->type === 'transfer';
                            $iconColor = $isIncome ? 'bg-emerald-500' : ($isTransfer ? 'bg-blue-600' : 'bg-red-500');
                            $amountPrefix = $isIncome ? '+' : '-';
                            $subtitle = ucfirst($trx->type) . ' - ' . ($trx->wallet->name ?? '-');
                        @endphp
                        <div class="flex items-center gap-3 py-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $iconColor }} text-white">
                                @if ($isTransfer)
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="m17 3 4 4-4 4" />
                                        <path d="M3 7h18" />
                                        <path d="m7 21-4-4 4-4" />
                                        <path d="M21 17H3" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="{{ $isIncome ? 'M12 19V5M5 12l7-7 7 7' : 'M12 5v14M5 12l7 7 7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-slate-900">
                                    {{ $trx->description ?: ($trx->category->name ?? ucfirst($trx->type)) }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $subtitle }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold {{ $isIncome ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $amountPrefix }}{{ $formatRupiah($trx->amount) }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $trx->transaction_date?->format('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-950">Budget Bulan Ini</h2>
                    <a href="{{ route('user.budget.index') }}"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($budgetStatus->take(5) as $budget)
                        @php
                            $barColor = $budget->status === 'exceeded' ? 'bg-red-500' : ($budget->status === 'warning' ? 'bg-amber-500' : 'bg-emerald-500');
                        @endphp
                        <div class="grid grid-cols-[36px_1fr_auto] items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 19V5" />
                                    <path d="M8 19v-8" />
                                    <path d="M12 19V7" />
                                    <path d="M16 19v-5" />
                                    <path d="M20 19v-9" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="mb-1 flex items-center justify-between gap-3">
                                    <span class="truncate text-sm font-medium text-slate-800">{{ $budget->category->name ?? '-' }}</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full {{ $barColor }}" style="width: {{ $budget->percentage }}%"></div>
                                </div>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $formatRupiah($budget->spent) }} / {{ $formatRupiah($budget->limit_amount) }}
                                </p>
                            </div>
                            <span class="text-sm font-semibold text-slate-800">{{ $budget->percentage }}%</span>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500">Belum ada budget yang diatur.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-950">Saving Goals</h2>
                    <a href="{{ route('user.saving.index') }}"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($savings->take(4) as $index => $saving)
                        @php
                            $savingColors = ['bg-blue-500', 'bg-emerald-500', 'bg-amber-500', 'bg-red-500'];
                            $iconBgs = ['bg-blue-50 text-blue-600', 'bg-emerald-50 text-emerald-600', 'bg-amber-50 text-amber-600', 'bg-red-50 text-red-600'];
                        @endphp
                        <div class="grid grid-cols-[36px_1fr_auto] items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg {{ $iconBgs[$index % count($iconBgs)] }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 3 4 7v6c0 5 3.5 7.5 8 8 4.5-.5 8-3 8-8V7Z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $saving->name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $formatRupiah($saving->saved_amount) }} / {{ $formatRupiah($saving->target_amount) }}
                                </p>
                                <div class="mt-2 h-2 rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full {{ $savingColors[$index % count($savingColors)] }}"
                                        style="width: {{ min($saving->progress, 100) }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ $saving->progress }}%</span>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500">Belum ada target tabungan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-950">Tagihan & Subscription Mendatang</h2>

            <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                @forelse($upcomingSubscriptions->take(4) as $index => $sub)
                    @php
                        $subscriptionBgs = ['bg-red-50 text-red-600', 'bg-emerald-50 text-emerald-600', 'bg-amber-50 text-amber-600', 'bg-slate-100 text-slate-600'];
                    @endphp
                    <div class="flex items-center gap-3 border-slate-100 xl:border-r xl:pr-4 last:border-r-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $subscriptionBgs[$index % count($subscriptionBgs)] }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M6 7h12l2 13H4Z" />
                                <path d="M9 7a3 3 0 0 1 6 0" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $sub->name }}</p>
                            <p class="text-xs text-slate-500">{{ $sub->next_billing->format('d M Y') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-slate-900">{{ $formatRupiah($sub->amount) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Tidak ada tagihan dalam 30 hari ke depan.</p>
                @endforelse
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Chart = window.Chart;

            if (!Chart) {
                return;
            }

            const cashflowElement = document.getElementById('cashflowChart');
            const categoryElement = document.getElementById('categoryChart');
            const rupiahShort = new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 1
            });

            if (cashflowElement) {
                new Chart(cashflowElement, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                                label: 'Income',
                                data: @json($incomeChartData),
                                borderColor: '#16a34a',
                                backgroundColor: '#16a34a',
                                borderWidth: 3,
                                pointRadius: 5,
                                pointHoverRadius: 6,
                                tension: 0.35
                            },
                            {
                                label: 'Expense',
                                data: @json($expenseChartData),
                                borderColor: '#ef4444',
                                backgroundColor: '#ef4444',
                                borderWidth: 3,
                                pointRadius: 5,
                                pointHoverRadius: 6,
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                align: 'end',
                                labels: {
                                    boxWidth: 10,
                                    boxHeight: 3,
                                    usePointStyle: true,
                                    pointStyle: 'line'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp ' + rupiahShort.format(context.raw / 1000000) + ' jt';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: '#e2e8f0',
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value === 0 ? '0' : rupiahShort.format(value / 1000000) + ' jt';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            if (categoryElement) {
                new Chart(categoryElement, {
                    type: 'doughnut',
                    data: {
                        labels: @json($categoryLabels),
                        datasets: [{
                            data: @json($categoryTotals->map(fn($value) => (float) $value)->values()),
                            backgroundColor: @json($categoryColors),
                            borderColor: '#ffffff',
                            borderWidth: 4,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
