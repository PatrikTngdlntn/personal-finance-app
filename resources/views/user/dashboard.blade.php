<x-app-layout>

    <div class="space-y-6">

        <!-- 🔝 SUMMARY -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-5 rounded-xl">
                <p class="text-sm text-gray-500">Total Balance</p>
                <h2 class="text-2xl font-bold mt-2">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white p-5 rounded-xl">
                <p class="text-sm text-gray-500">Income</p>
                <h2 class="text-2xl font-bold mt-2 text-green-600">
                    Rp {{ number_format($income, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white p-5 rounded-xl">
                <p class="text-sm text-gray-500">Expense</p>
                <h2 class="text-2xl font-bold mt-2 text-red-500">
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </h2>
            </div>

        </div>

        <!-- 📊 EXPENSE BY CATEGORY -->
        <div class="bg-white p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Pengeluaran per Kategori</h3>

            @forelse($expenseByCategory as $item)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                    <span>Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-gray-400">Belum ada data</p>
            @endforelse
        </div>

        <!-- 📋 TRANSAKSI TERBARU -->
        <div class="bg-white p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>

            @forelse($recentTransactions as $trx)
                <div class="flex justify-between border-b py-2">
                    <div>
                        <p class="font-medium">{{ $trx->category->name ?? '-' }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $trx->wallet->name ?? '-' }} • {{ $trx->transaction_date }}
                        </p>
                    </div>

                    <span
                        class="
                        {{ $trx->type === 'income' ? 'text-green-600' : 'text-red-500' }}
                    ">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </span>
                </div>
            @empty
                <p class="text-gray-400">Belum ada transaksi</p>
            @endforelse
        </div>

        <!-- 💸 BUDGET -->
        <div class="bg-white p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Budget</h3>

            @forelse($budgetStatus as $budget)
                <div class="mb-3">
                    <div class="flex justify-between text-sm">
                        <span>{{ $budget->category->name }}</span>
                        <span>{{ $budget->percentage }}%</span>
                    </div>

                    <div class="w-full bg-gray-200 h-2 rounded mt-1">
                        <div class="
                            h-2 rounded
                            {{ $budget->status === 'safe' ? 'bg-green-500' : '' }}
                            {{ $budget->status === 'warning' ? 'bg-yellow-400' : '' }}
                            {{ $budget->status === 'exceeded' ? 'bg-red-500' : '' }}
                        "
                            style="width: {{ $budget->percentage }}%">
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-400">Belum ada budget</p>
            @endforelse
        </div>

        <!-- 🏦 SAVING -->
        <div class="bg-white p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Tabungan</h3>

            @forelse($savings as $saving)
                <div class="mb-3">
                    <p class="font-medium">{{ $saving->name }}</p>
                    <p class="text-sm text-gray-400">
                        {{ $saving->progress }}% tercapai
                    </p>
                </div>
            @empty
                <p class="text-gray-400">Belum ada tabungan</p>
            @endforelse
        </div>

        <!-- 🔔 SUBSCRIPTION -->
        <div class="bg-white p-5 rounded-xl">
            <h3 class="font-semibold mb-4">Tagihan Mendatang</h3>

            @forelse($upcomingSubscriptions as $sub)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $sub->name }}</span>
                    <span>{{ $sub->next_billing }}</span>
                </div>
            @empty
                <p class="text-gray-400">Tidak ada tagihan</p>
            @endforelse
        </div>

    </div>

</x-app-layout>
