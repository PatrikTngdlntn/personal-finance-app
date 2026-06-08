<x-app-layout title="Savings">
    @php
        $formatRupiah = fn($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');
        $totalSaved = $allSavings->sum('saved_amount');
        $totalTarget = $allSavings->sum('target_amount');
        $overallProgress = $totalTarget > 0 ? min(round(($totalSaved / $totalTarget) * 100), 100) : 0;
    @endphp

    <div class="space-y-6">
        <header class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Savings</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola target tabungan, setor, tarik, dan lihat riwayatnya dari satu halaman.
                </p>
            </div>

            <a href="{{ route('user.saving.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Tambah Target
            </a>
        </header>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Terkumpul</p>
                <p class="mt-2 text-2xl font-bold text-slate-950">{{ $formatRupiah($totalSaved) }}</p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Target</p>
                <p class="mt-2 text-2xl font-bold text-slate-950">{{ $formatRupiah($totalTarget) }}</p>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">Progress Keseluruhan</p>
                    <p class="text-sm font-semibold text-blue-600">{{ $overallProgress }}%</p>
                </div>
                <div class="mt-4 h-2 rounded-full bg-slate-200">
                    <div class="h-2 rounded-full bg-blue-600" style="width: {{ $overallProgress }}%"></div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_420px]">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-950">Target Tabungan</h2>
                    <span class="text-sm text-slate-500">{{ $savings->total() }} target</span>
                </div>

                @if ($savings->count() < 1)
                    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-12 text-center">
                        <h3 class="text-lg font-semibold text-slate-800">Belum ada target tabungan</h3>
                        <p class="mt-2 text-sm text-slate-500">Buat target tabungan pertama kamu.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach ($savings as $saving)
                            @php
                                $percentage = $saving->target_amount > 0
                                    ? min(round(($saving->saved_amount / $saving->target_amount) * 100), 100)
                                    : 0;
                            @endphp

                            <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-lg font-bold text-slate-950">{{ $saving->name }}</h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            Target {{ $formatRupiah($saving->target_amount) }}
                                        </p>
                                    </div>

                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                        {{ $percentage }}%
                                    </span>
                                </div>

                                <div class="mt-5">
                                    <div class="h-2 rounded-full bg-slate-200">
                                        <div class="h-2 rounded-full bg-blue-600" style="width: {{ $percentage }}%"></div>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Terkumpul</span>
                                        <span class="font-semibold text-slate-800">
                                            {{ $formatRupiah($saving->saved_amount) }}
                                        </span>
                                    </div>
                                </div>

                                @if ($saving->target_date)
                                    <p class="mt-4 text-sm text-slate-500">
                                        Target tanggal {{ $saving->target_date->format('d M Y') }}
                                    </p>
                                @endif

                                <div class="mt-5 flex flex-wrap items-center gap-2">
                                    <a href="#saving-transaction-form"
                                        class="inline-flex flex-1 items-center justify-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-100">
                                        Setor / Tarik
                                    </a>

                                    <a href="{{ route('user.saving.edit', $saving->id) }}"
                                        class="inline-flex flex-1 items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                        Edit
                                    </a>

                                    <form action="{{ route('user.saving.destroy', $saving->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus target tabungan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div>
                        {{ $savings->links() }}
                    </div>
                @endif
            </div>

            <aside id="saving-transaction-form" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-950">Tambah Transaksi Tabungan</h2>
                    <p class="mt-1 text-sm text-slate-500">Setor ke target tabungan atau tarik kembali ke wallet.</p>
                </div>

                <form method="POST" action="{{ route('user.saving-transaction.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tipe Transaksi</label>
                        <select name="type"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="deposit" {{ old('type') === 'deposit' ? 'selected' : '' }}>
                                Deposit / Menabung
                            </option>
                            <option value="withdraw" {{ old('type') === 'withdraw' ? 'selected' : '' }}>
                                Withdraw / Ambil Tabungan
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Target Tabungan</label>
                        <select name="savings_id"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih target tabungan</option>
                            @foreach ($allSavings as $saving)
                                <option value="{{ $saving->id }}" {{ old('savings_id') == $saving->id ? 'selected' : '' }}>
                                    {{ $saving->name }} - {{ $formatRupiah($saving->saved_amount) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Wallet</label>
                        <select name="wallet_id"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih wallet</option>
                            @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }} - {{ $formatRupiah($wallet->initial_balance) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Jumlah</label>
                        <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}"
                            placeholder="Masukkan nominal"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date"
                            value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Catatan opsional"
                            class="w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                        Simpan Transaksi
                    </button>
                </form>
            </aside>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-950">Riwayat Transaksi Tabungan</h2>
                    <p class="mt-1 text-sm text-slate-500">Deposit dan withdraw dari semua target tabungan.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-4 font-medium">Target</th>
                            <th class="px-5 py-4 font-medium">Wallet</th>
                            <th class="px-5 py-4 font-medium">Tipe</th>
                            <th class="px-5 py-4 font-medium">Jumlah</th>
                            <th class="px-5 py-4 font-medium">Tanggal</th>
                            <th class="px-5 py-4 font-medium">Deskripsi</th>
                            <th class="px-5 py-4 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($savingTransactions as $transaction)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-medium text-slate-900">
                                    {{ $transaction->savingAccount->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $transaction->wallet->name ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $transaction->type === 'deposit' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                        {{ $transaction->type === 'deposit' ? 'Deposit' : 'Withdraw' }}
                                    </span>
                                </td>
                                <td
                                    class="px-5 py-4 font-semibold {{ $transaction->type === 'deposit' ? 'text-emerald-600' : 'text-amber-600' }}">
                                    {{ $transaction->type === 'deposit' ? '+' : '-' }}{{ $formatRupiah($transaction->amount) }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $transaction->transaction_date?->format('d M Y') }}
                                </td>
                                <td class="max-w-xs truncate px-5 py-4 text-slate-500">
                                    {{ $transaction->description ?? '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('user.saving-transaction.edit', $transaction->id) }}"
                                            class="font-medium text-blue-600 hover:text-blue-700">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('user.saving-transaction.destroy', $transaction->id) }}"
                                            onsubmit="return confirm('Hapus transaksi tabungan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="font-medium text-red-600 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                    Belum ada transaksi tabungan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($savingTransactions->hasPages())
                <div class="border-t border-slate-100 p-5">
                    {{ $savingTransactions->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
