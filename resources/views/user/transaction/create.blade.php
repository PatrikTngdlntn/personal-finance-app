<x-app-layout>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-sm">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Tambah Transaksi
        </h2>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">

                <ul class="list-disc list-inside space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        <form method="POST" action="{{ route('user.transaction.store') }}" class="space-y-5">

            @csrf

            {{-- TYPE --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Transaksi
                </label>

                <select name="type" id="type"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>

                        Income
                    </option>

                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>

                        Expense
                    </option>

                    <option value="transfer" {{ old('type') == 'transfer' ? 'selected' : '' }}>

                        Transfer
                    </option>

                </select>

            </div>

            {{-- WALLET ASAL --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Dari Wallet
                </label>

                <select name="wallet_id"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500">

                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>

                            {{ $wallet->name }}

                        </option>
                    @endforeach

                </select>

            </div>

            {{-- TRANSFER --}}
            <div id="transferField" class="hidden">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ke Wallet
                </label>

                <select name="transfer_to_wallet_id"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="">
                        -- pilih wallet --
                    </option>

                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}"
                            {{ old('transfer_to_wallet_id') == $wallet->id ? 'selected' : '' }}>

                            {{ $wallet->name }}

                        </option>
                    @endforeach

                </select>

            </div>

            {{-- CATEGORY --}}
            <div id="categoryField">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>

                <select name="category_id" id="categorySelect"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="">
                        -- pilih kategori --
                    </option>

                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" data-type="{{ $cat->type }}"
                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>

                            {{ $cat->name }}

                        </option>
                    @endforeach

                </select>

            </div>

            {{-- AMOUNT --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah
                </label>

                <input type="number" name="amount" value="{{ old('amount') }}"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Masukkan jumlah" required>

            </div>

            {{-- DATE --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal
                </label>

                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500" required>

            </div>

            {{-- DESCRIPTION --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>

                <textarea name="description" rows="4"
                    class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end">

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700
                    text-white px-5 py-3 rounded-xl font-medium transition">

                    Simpan Transaksi
                </button>

            </div>

        </form>

    </div>

    {{-- SCRIPT --}}
    <script>
        const typeSelect = document.getElementById('type');
        const transferField = document.getElementById('transferField');
        const categoryField = document.getElementById('categoryField');
        const categorySelect = document.getElementById('categorySelect');

        function filterCategory() {

            const type = typeSelect.value;

            // transfer
            if (type === 'transfer') {

                transferField.classList.remove('hidden');
                categoryField.classList.add('hidden');

            } else {

                transferField.classList.add('hidden');
                categoryField.classList.remove('hidden');

            }

            // filter category
            Array.from(categorySelect.options).forEach(option => {

                if (!option.dataset.type) {
                    option.hidden = false;
                    return;
                }

                option.hidden = option.dataset.type !== type;
            });

            categorySelect.value = '';
        }

        typeSelect.addEventListener('change', filterCategory);

        filterCategory();
    </script>

</x-app-layout>
