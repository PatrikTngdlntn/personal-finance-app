<x-app-layout title="Tambah Subscription">

    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- HEADER --}}
            <div class="mb-6">

                <h1 class="text-2xl font-bold text-gray-800">
                    Tambah Subscription
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan tagihan langganan baru
                </p>

            </div>

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-100 px-4 py-3 text-sm text-red-700">

                    <ul class="ml-5 list-disc space-y-1">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('user.subscription.store') }}" class="space-y-6">

                @csrf

                {{-- NAMA --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Nama Subscription
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Netflix"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                </div>

                {{-- WALLET --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Wallet Pembayaran
                    </label>

                    <select name="wallet_id"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                        <option value="">
                            -- Pilih Wallet --
                        </option>

                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>

                                {{ $wallet->name }}
                                (Rp {{ number_format($wallet->initial_balance, 0, ',', '.') }})
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- JUMLAH --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Jumlah Tagihan
                    </label>

                    <input type="number" name="amount" value="{{ old('amount') }}" placeholder="50000"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                </div>

                {{-- CURRENCY --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Mata Uang
                    </label>

                    <select name="currency"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                        <option value="IDR" {{ old('currency') == 'IDR' ? 'selected' : '' }}>
                            IDR
                        </option>

                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>
                            USD
                        </option>

                    </select>

                </div>

                {{-- BILLING --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Siklus Tagihan
                    </label>

                    <select name="billing_cycle"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                        <option value="daily" {{ old('billing_cycle') == 'daily' ? 'selected' : '' }}>
                            Harian
                        </option>

                        <option value="weekly" {{ old('billing_cycle') == 'weekly' ? 'selected' : '' }}>
                            Mingguan
                        </option>

                        <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>
                            Bulanan
                        </option>

                        <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>
                            Tahunan
                        </option>

                    </select>

                </div>

                {{-- NEXT BILLING --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Tanggal Tagihan Berikutnya
                    </label>

                    <input type="date" name="next_billing" value="{{ old('next_billing', now()->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3">

                    <a href="{{ route('user.subscription.index') }}"
                        class="rounded-xl border border-gray-200 px-5 py-3 text-gray-600 transition hover:bg-gray-100">

                        Batal
                    </a>

                    <button type="submit"
                        class="rounded-xl bg-indigo-600 px-5 py-3 font-medium text-white transition hover:bg-indigo-700">

                        Simpan Subscription
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
