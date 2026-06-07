<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

        {{-- HEADER --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Edit Transaksi
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Ubah data transaksi keuangan
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.transaction.update', $transaction->id) }}" class="space-y-5">

            @csrf
            @method('PUT')

            {{-- TYPE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Transaksi
                </label>

                <select name="type" id="type"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>
                        Income
                    </option>

                    <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>
                        Expense
                    </option>

                    <option value="transfer" {{ $transaction->type == 'transfer' ? 'selected' : '' }}>
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
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}"
                            {{ $transaction->wallet_id == $wallet->id ? 'selected' : '' }}>

                            {{ $wallet->name }}
                            (Rp {{ number_format($wallet->initial_balance, 0, ',', '.') }})
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- WALLET TUJUAN --}}
            <div id="transferField" class="{{ $transaction->type !== 'transfer' ? 'hidden' : '' }}">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ke Wallet
                </label>

                <select name="transfer_to_wallet_id"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="">
                        -- Pilih Wallet --
                    </option>

                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}"
                            {{ $transaction->transfer_to_wallet_id == $wallet->id ? 'selected' : '' }}>

                            {{ $wallet->name }}

                        </option>
                    @endforeach

                </select>
            </div>

            {{-- CATEGORY --}}
            <div id="categoryField" class="{{ $transaction->type === 'transfer' ? 'hidden' : '' }}">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>

                <select name="category_id" id="category_id"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" data-type="{{ $cat->type }}"
                            {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>

                            {{ $cat->name }} ({{ ucfirst($cat->type) }})

                        </option>
                    @endforeach

                </select>
            </div>

            {{-- AMOUNT --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah
                </label>

                <input type="number" name="amount" value="{{ $transaction->amount }}" placeholder="Masukkan jumlah"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">
            </div>

            {{-- DATE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal
                </label>

                <input type="date" name="transaction_date"
                    value="{{ $transaction->transaction_date->format('Y-m-d') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>

                <textarea name="description" rows="4" placeholder="Catatan tambahan..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500">{{ $transaction->description }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('user.transaction.index') }}"
                    class="px-5 py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-100 transition">

                    Batal
                </a>

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700
                    text-white px-5 py-3 rounded-xl
                    font-medium transition">

                    Update Transaksi
                </button>

            </div>

        </form>
    </div>

    {{-- SCRIPT --}}
    <script>
        const typeSelect = document.getElementById('type');
        const transferField = document.getElementById('transferField');
        const categoryField = document.getElementById('categoryField');
        const categorySelect = document.getElementById('category_id');

        function filterCategory() {

            const selectedType = typeSelect.value;

            Array.from(categorySelect.options).forEach(option => {

                if (option.value === '') {
                    option.hidden = false;
                    return;
                }

                const categoryType = option.dataset.type;

                if (selectedType === 'transfer') {

                    option.hidden = true;

                } else {

                    option.hidden = categoryType !== selectedType;
                }
            });

            const selectedOption =
                categorySelect.options[categorySelect.selectedIndex];

            if (
                selectedOption &&
                selectedOption.dataset.type !== selectedType
            ) {
                categorySelect.value = '';
            }
        }

        function toggleFields() {

            if (typeSelect.value === 'transfer') {

                transferField.classList.remove('hidden');
                categoryField.classList.add('hidden');

            } else {

                transferField.classList.add('hidden');
                categoryField.classList.remove('hidden');
            }

            filterCategory();
        }

        typeSelect.addEventListener('change', toggleFields);

        // INIT
        toggleFields();
    </script>
</x-app-layout>
