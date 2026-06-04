<x-app-layout title="Dashboard">

    <div class="space-y-6">

        {{-- 🔝 SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Balance</p>
                <h2 class="text-2xl font-bold mt-2">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </h2>
                <p class="text-xs text-gray-400 mt-1">{{ $wallets->count() }} wallet aktif</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Income Bulan Ini</p>
                <h2 class="text-2xl font-bold mt-2 text-green-600">
                    Rp {{ number_format($income, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Expense Bulan Ini</p>
                <h2 class="text-2xl font-bold mt-2 text-red-500">
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </h2>
            </div>

        </div>

        {{-- 📊 EXPENSE BY CATEGORY --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Pengeluaran per Kategori</h3>

            @forelse($expenseByCategory as $item)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                    <span class="font-medium">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada data pengeluaran bulan ini</p>
            @endforelse
        </div>

        {{-- 📋 TRANSAKSI TERBARU --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>

            @forelse($recentTransactions as $trx)
                <div class="flex justify-between border-b py-2">
                    <div>
                        <p class="font-medium">{{ $trx->category->name ?? '-' }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $trx->wallet->name ?? '-' }} • {{ $trx->transaction_date?->format('d M Y') ?? '-' }}
                        </p>
                    </div>

                    {{-- Bug #11 Fix: transfer sekarang berwarna biru, bukan merah --}}
                    @php
                        $colorClass = match($trx->type) {
                            'income'   => 'text-green-600',
                            'expense'  => 'text-red-500',
                            'transfer' => 'text-blue-500',
                            default    => 'text-gray-500',
                        };
                    @endphp
                    <span class="{{ $colorClass }} font-medium">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada transaksi</p>
            @endforelse
        </div>

        {{-- 💸 BUDGET --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-semibold mb-4">Budget Bulan Ini</h3>

            @forelse($budgetStatus as $budget)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $budget->category->name ?? '-' }}</span>
                        <span class="
                            {{ $budget->status === 'exceeded' ? 'text-red-600 font-semibold' : '' }}
                            {{ $budget->status === 'warning'  ? 'text-yellow-600 font-semibold' : '' }}
                            {{ $budget->status === 'safe'     ? 'text-green-600' : '' }}
                        ">
                            {{ $budget->percentage }}%
                            (Rp {{ number_format($budget->spent, 0, ',', '.') }}
                            / Rp {{ number_format($budget->limit_amount, 0, ',', '.') }})
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 h-2 rounded">
                        <div class="h-2 rounded transition-all duration-300
                            {{ $budget->status === 'safe'     ? 'bg-green-500' : '' }}
                            {{ $budget->status === 'warning'  ? 'bg-yellow-400' : '' }}
                            {{ $budget->status === 'exceeded' ? 'bg-red-500' : '' }}
                        " style="width: {{ $budget->percentage }}%"></div>
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
