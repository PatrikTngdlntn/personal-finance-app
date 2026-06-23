<x-app-layout title="Hasil OCR">

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- HASIL OCR --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-2xl font-bold mb-4">
                Hasil OCR
            </h1>

            {{-- Gambar --}}
            <div class="mb-6">
                <img src="{{ asset('storage/' . $receipt->image_path) }}"
                    class="rounded-lg border w-full max-h-[500px] object-contain">
            </div>

            {{-- INFORMASI OCR --}}
            <div class="grid md:grid-cols-3 gap-4 mb-6">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Nominal Terdeteksi
                    </p>

                    <p class="text-xl font-bold text-green-600">
                        Rp {{ number_format($receipt->ocr_amount ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Merchant
                    </p>

                    <p class="font-semibold">
                        {{ $merchant ?? '-' }}
                    </p>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Tanggal
                    </p>

                    <p class="font-semibold">
                        {{ $date ?? '-' }}
                    </p>
                </div>

            </div>

            {{-- OCR TEXT --}}
            <div>

                <label class="block text-sm font-medium text-gray-500 mb-2">
                    Hasil OCR
                </label>

                <textarea rows="15" class="w-full border rounded-lg p-3 bg-gray-50" readonly>{{ $receipt->ocr_text }}</textarea>

            </div>

        </div>

        {{-- CONVERT KE TRANSAKSI --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-bold mb-6">
                Convert ke Transaksi
            </h2>

            <form method="POST" action="{{ route('user.receipt.convert', $receipt->id) }}">
                @csrf

                {{-- TYPE --}}
                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        Tipe Transaksi
                    </label>

                    <select name="type" class="w-full border rounded-lg px-3 py-2">

                        <option value="expense">
                            Expense
                        </option>

                        <option value="income">
                            Income
                        </option>

                    </select>

                </div>

                {{-- WALLET --}}
                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        Wallet
                    </label>

                    <select name="wallet_id" class="w-full border rounded-lg px-3 py-2">

                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}">
                                {{ $wallet->name }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- CATEGORY --}}
                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        Kategori
                    </label>

                    <select name="category_id" class="w-full border rounded-lg px-3 py-2">

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- NOMINAL --}}
                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        Nominal
                    </label>

                    <input type="number" name="amount" value="{{ $receipt->ocr_amount }}"
                        class="w-full border rounded-lg px-3 py-2">

                </div>

                {{-- TANGGAL --}}
                <div class="mb-4">

                    <label class="block text-sm font-medium mb-2">
                        Tanggal Transaksi
                    </label>

                    <input type="date" name="transaction_date" value="{{ now()->format('Y-m-d') }}"
                        class="w-full border rounded-lg px-3 py-2">

                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium mb-2">
                        Deskripsi
                    </label>

                    <input type="text" name="description" value="{{ $merchant }}"
                        class="w-full border rounded-lg px-3 py-2">

                </div>

                {{-- BUTTON --}}
                <div class="flex gap-3">

                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg">
                        Simpan ke Transaksi
                    </button>

                    <a href="{{ route('user.receipt.create') }}" class="px-5 py-2 bg-gray-200 rounded-lg">

                        Scan Lagi

                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
