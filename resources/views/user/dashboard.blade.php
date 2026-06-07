<x-app-layout title="Dashboard">
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document
                .getElementById('cashflowChart')
                .getContext('2d');

            new Chart(ctx, {
                type: 'line',

                data: {

                    labels: @json($chartLabels),

                    datasets: [

                        {
                            label: 'Income',
                            data: @json($incomeChartData),
                            borderColor: '#22c55e',
                            backgroundColor: '#22c55e',
                            tension: 0.4,
                            fill: false
                        },

                        {
                            label: 'Expense',
                            data: @json($expenseChartData),
                            borderColor: '#ef4444',
                            backgroundColor: '#ef4444',
                            tension: 0.4,
                            fill: false
                        }
                    ]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },

                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>

    <div class="space-y-6">

        {{-- 🔝 SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- TOTAL BALANCE --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Total Balance
                        </p>

                        <h2 class="text-2xl font-bold mt-2">
                            Rp {{ number_format($totalBalance, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100
                flex items-center justify-center text-xl">
                        💰
                    </div>

                </div>

                <p class="text-xs text-gray-400 mt-3">
                    {{ $wallets->count() }} wallet aktif
                </p>

            </div>

            {{-- INCOME --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Income
                        </p>

                        <h2 class="text-2xl font-bold mt-2 text-green-600">
                            Rp {{ number_format($income, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div
                        class="w-12 h-12 rounded-xl bg-green-100
                flex items-center justify-center text-xl">
                        📈
                    </div>

                </div>

            </div>

            {{-- EXPENSE --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Expense
                        </p>

                        <h2 class="text-2xl font-bold mt-2 text-red-500">
                            Rp {{ number_format($expense, 0, ',', '.') }}
                        </h2>
                    </div>

                    <div
                        class="w-12 h-12 rounded-xl bg-red-100
                flex items-center justify-center text-xl">
                        📉
                    </div>

                </div>

            </div>

            {{-- SAVING --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-500 text-sm">
                            Saving Goal
                        </p>

                        <h2 class="text-2xl font-bold mt-2 text-indigo-600">
                            {{ $savings->count() }}
                        </h2>
                    </div>

                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-100
                flex items-center justify-center text-xl">
                        🎯
                    </div>

                </div>

            </div>

        </div>

        {{-- 📊 EXPENSE BY CATEGORY --}}
        {{-- 📈 CASH FLOW CHART --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="font-semibold text-lg">Cash Flow</h3>
                    <p class="text-sm text-gray-400">
                        Income vs Expense 6 bulan terakhir
                    </p>
                </div>
            </div>

            <div class="h-80">
                <canvas id="cashflowChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <h3 class="font-semibold mb-5">
                Pengeluaran per Kategori
            </h3>

            @php
                $maxExpense = $expenseByCategory->max('total') ?: 1;
            @endphp

            @forelse($expenseByCategory as $item)
                @php
                    $percent = ($item->total / $maxExpense) * 100;
                @endphp

                <div class="mb-4">

                    <div class="flex justify-between mb-1">

                        <span>
                            {{ $item->category->name ?? 'Tanpa Kategori' }}
                        </span>

                        <span>
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        </span>

                    </div>

                    <div class="bg-gray-200 rounded-full h-2">

                        <div class="bg-indigo-500 h-2 rounded-full" style="width:{{ $percent }}%">
                        </div>

                    </div>

                </div>

            @empty

                <p class="text-gray-400">
                    Belum ada data
                </p>
            @endforelse

        </div>

        {{-- 📋 TRANSAKSI TERBARU --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <h3 class="font-semibold mb-4">
                Recent Transaction
            </h3>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">
                                Kategori
                            </th>

                            <th class="text-left py-3">
                                Wallet
                            </th>

                            <th class="text-left py-3">
                                Tanggal
                            </th>

                            <th class="text-right py-3">
                                Nominal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($recentTransactions as $trx)
                            <tr class="border-b">

                                <td class="py-3">
                                    {{ $trx->category->name ?? '-' }}
                                </td>

                                <td class="py-3">
                                    {{ $trx->wallet->name ?? '-' }}
                                </td>

                                <td class="py-3">
                                    {{ $trx->transaction_date?->format('d M Y') }}
                                </td>

                                <td class="text-right py-3">

                                    <span
                                        class="
                        {{ $trx->type == 'income' ? 'text-green-600' : '' }}
                        {{ $trx->type == 'expense' ? 'text-red-500' : '' }}
                        {{ $trx->type == 'transfer' ? 'text-blue-500' : '' }}
                        font-semibold">

                                        Rp {{ number_format($trx->amount, 0, ',', '.') }}

                                    </span>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- 💸 BUDGET --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Budget Bulan Ini</h3>

            @forelse($budgetStatus as $budget)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $budget->category->name ?? '-' }}</span>
                        <span
                            class="
                            {{ $budget->status === 'exceeded' ? 'text-red-600 font-semibold' : '' }}
                            {{ $budget->status === 'warning' ? 'text-yellow-600 font-semibold' : '' }}
                            {{ $budget->status === 'safe' ? 'text-green-600' : '' }}
                        ">
                            {{ $budget->percentage }}%
                            (Rp {{ number_format($budget->spent, 0, ',', '.') }}
                            / Rp {{ number_format($budget->limit_amount, 0, ',', '.') }})
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 h-2 rounded">
                        <div class="h-2 rounded transition-all duration-300
                            {{ $budget->status === 'safe' ? 'bg-green-500' : '' }}
                            {{ $budget->status === 'warning' ? 'bg-yellow-400' : '' }}
                            {{ $budget->status === 'exceeded' ? 'bg-red-500' : '' }}
                        "
                            style="width: {{ $budget->percentage }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada budget yang diatur</p>
            @endforelse
        </div>

        {{-- 🏦 SAVING --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Tabungan</h3>

            @forelse($savings as $saving)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium">{{ $saving->name }}</span>
                        {{-- Bug #7 Fix: progress sekarang dihitung di controller --}}
                        <span class="text-gray-500">
                            {{ $saving->progress }}% tercapai
                            (Rp {{ number_format($saving->saved_amount, 0, ',', '.') }}
                            / Rp {{ number_format($saving->target_amount, 0, ',', '.') }})
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 h-2 rounded">
                        <div class="h-2 rounded bg-indigo-500 transition-all duration-300"
                            style="width: {{ $saving->progress }}%"></div>
                    </div>
                    @if ($saving->target_date)
                        <p class="text-xs text-gray-400 mt-1">
                            Target: {{ $saving->target_date->format('d M Y') }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada tabungan</p>
            @endforelse
        </div>

        {{-- 🔔 SUBSCRIPTION --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Tagihan Mendatang (30 hari)</h3>

            @forelse($upcomingSubscriptions as $sub)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $sub->name }}</span>
                    <div class="text-right">
                        <p class="text-sm font-medium">Rp {{ number_format($sub->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $sub->next_billing->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Tidak ada tagihan dalam 30 hari ke depan</p>
            @endforelse
        </div>

    </div>

</x-app-layout>
