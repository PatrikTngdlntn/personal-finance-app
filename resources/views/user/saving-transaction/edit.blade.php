<x-app-layout title="Edit Transaksi Tabungan">

    <div class="max-w-2xl mx-auto">

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- HEADER --}}
            <div class="mb-8">

                <h1 class="text-2xl font-bold text-gray-800">
                    Edit Transaksi Tabungan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Ubah data transaksi tabungan
                </p>

            </div>

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-4 rounded-2xl mb-6">

                    <ul class="list-disc ml-5 space-y-1 text-sm">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('user.saving-transaction.update', $savingTransaction->id) }}"
                class="space-y-6">

                @csrf
                @method('PUT')

                {{-- TYPE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Transaksi
                    </label>

                    <select name="type"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                        <option value="deposit"
                            {{ old('type', $savingTransaction->type) == 'deposit' ? 'selected' : '' }}>

                            Deposit / Menabung

                        </option>

                        <option value="withdraw"
                            {{ old('type', $savingTransaction->type) == 'withdraw' ? 'selected' : '' }}>

                            Withdraw / Ambil Tabungan

                        </option>

                    </select>

                </div>

                {{-- TARGET TABUNGAN --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Target Tabungan
                    </label>

                    <select name="savings_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                        <option value="">
                            -- Pilih Target Tabungan --
                        </option>

                        @foreach ($savings as $saving)
                            <option value="{{ $saving->id }}"
                                {{ old('savings_id', $savingTransaction->savings_id) == $saving->id ? 'selected' : '' }}>

                                {{ $saving->name }}
                                -
                                Rp {{ number_format($saving->saved_amount, 0, ',', '.') }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- WALLET --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Wallet
                    </label>

                    <select name="wallet_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                        <option value="">
                            -- Pilih Wallet --
                        </option>

                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}"
                                {{ old('wallet_id', $savingTransaction->wallet_id) == $wallet->id ? 'selected' : '' }}>

                                {{ $wallet->name }}
                                -
                                Rp {{ number_format($wallet->initial_balance, 0, ',', '.') }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- AMOUNT --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah
                    </label>

                    <input type="number" step="0.01" min="1" name="amount"
                        value="{{ old('amount', $savingTransaction->amount) }}" placeholder="Masukkan jumlah transaksi"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                </div>

                {{-- DATE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Transaksi
                    </label>

                    <input type="date" name="transaction_date"
                        value="{{ old('transaction_date', \Carbon\Carbon::parse($savingTransaction->transaction_date)->format('Y-m-d')) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                </div>

                {{-- DESCRIPTION --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea name="description" rows="4" placeholder="Tambahkan catatan jika diperlukan..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $savingTransaction->description) }}</textarea>

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex items-center justify-end gap-3 pt-4">

                    <a href="{{ route('user.saving-transaction.index') }}"
                        class="px-5 py-3 rounded-xl border border-gray-200
                        text-gray-600 hover:bg-gray-100 transition">

                        Batal
                    </a>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700
                        text-white px-6 py-3 rounded-xl
                        font-medium transition shadow-sm">

                        Update Transaksi
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
