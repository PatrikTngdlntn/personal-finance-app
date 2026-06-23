<x-app-layout>
    <div class="space-y-4">

        <div class="flex justify-between">
            <h2 class="text-xl font-bold">Transaksi</h2>

            <a href="{{ route('user.transaction.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                + Tambah
            </a>
        </div>

        <div class="bg-white rounded-xl p-4">

            @forelse($transactions as $trx)
                <div class="flex justify-between border-b py-3">

                    <div>
                        <p class="font-semibold">
                            {{ ucfirst($trx->type) }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $trx->wallet->name ?? '-' }}

                            @if ($trx->type === 'transfer')
                                → {{ $trx->transferToWallet->name ?? '-' }}
                            @endif
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $trx->transaction_date }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p
                            class="
                            {{ $trx->type === 'income' ? 'text-green-600' : '' }}
                            {{ $trx->type === 'expense' ? 'text-red-500' : '' }}
                            {{ $trx->type === 'transfer' ? 'text-blue-500' : '' }}
                        ">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </p>

                        <div class="text-xs mt-1">
                            <a href="{{ route('user.transaction.edit', $trx->id) }}" class="text-blue-500">Edit</a>

                            <form method="POST" action="{{ route('user.transaction.destroy', $trx->id) }}"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500">Hapus</button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-gray-400">Belum ada transaksi</p>
            @endforelse

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>
</x-app-layout>
