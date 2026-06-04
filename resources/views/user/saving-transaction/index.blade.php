<x-app-layout title="Saving Transactions">

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Saving Transactions
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Riwayat tabungan yang telah dilakukan
                </p>
            </div>

            <a href="{{ route('user.saving-transaction.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700
                text-white px-5 py-3 rounded-xl
                text-sm font-medium transition">

                + Tambah Tabungan
            </a>

        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">

                        <tr>
                            <th class="px-6 py-4 text-left">Target</th>
                            <th class="px-6 py-4 text-left">Wallet</th>
                            <th class="px-6 py-4 text-left">Jumlah</th>
                            <th class="px-6 py-4 text-left">Tanggal</th>
                            <th class="px-6 py-4 text-left">Deskripsi</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $trx->saving->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $trx->wallet->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-indigo-600">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $trx->transaction_date?->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $trx->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center">

                                        <form method="POST"
                                            action="{{ route('user.saving-transaction.destroy', $trx->id) }}"
                                            onsubmit="return confirm('Hapus transaksi tabungan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-500 hover:text-red-600 text-sm font-medium">

                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400">

                                    Belum ada transaksi tabungan

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}
        <div>
            {{ $transactions->links() }}
        </div>

    </div>

</x-app-layout>
