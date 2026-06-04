<x-app-layout title="Tambah Wallet">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-sm">

        <h2 class="text-xl font-bold mb-4">Tambah Wallet</h2>

        {{-- Error Validasi --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.wallet.store') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Nama Wallet</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Contoh: BCA Tabungan" required>
            </div>

            {{-- Tipe Wallet (Bug #2: field ini sebelumnya tidak ada!) --}}
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Tipe Wallet</label>
                <select name="type"
                    class="w-full border rounded-lg p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="cash"     {{ old('type') === 'cash'     ? 'selected' : '' }}>💵 Cash</option>
                    <option value="bank"     {{ old('type') === 'bank'     ? 'selected' : '' }}>🏦 Bank</option>
                    <option value="e-wallet" {{ old('type') === 'e-wallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                </select>
            </div>

            {{-- Saldo Awal --}}
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700">Saldo Awal</label>
                <input type="number" name="initial_balance" value="{{ old('initial_balance', 0) }}"
                    class="w-full border rounded-lg p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    min="0" step="1000" required>
            </div>

            {{-- Currency --}}
            <div class="mb-6">
                <label class="text-sm font-medium text-gray-700">Currency</label>
                <input type="text" name="currency" value="{{ old('currency', 'IDR') }}"
                    class="w-full border rounded-lg p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    maxlength="10">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan
                </button>
                <a href="{{ route('user.wallet.index') }}"
                    class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </a>
            </div>

        </form>

    </div>

</x-app-layout>
