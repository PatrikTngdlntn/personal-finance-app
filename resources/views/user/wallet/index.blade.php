<x-app-layout title="Wallet">

    <div class="space-y-6">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold">Wallet</h2>
            <a href="{{ route('user.wallet.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                + Tambah Wallet
            </a>
        </div>

        {{-- LIST WALLET --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($wallets as $wallet)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">

                    <div class="flex justify-between items-start">
                        <div>
                            <span
                                class="text-xs font-medium px-2 py-0.5 rounded-full
                                {{ $wallet->type === 'cash' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $wallet->type === 'bank' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $wallet->type === 'e-wallet' ? 'bg-purple-100 text-purple-700' : '' }}
                            ">
                                {{ ucfirst($wallet->type) }}
                            </span>
                            <h3 class="font-semibold mt-2">{{ $wallet->name }}</h3>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('user.wallet.edit', $wallet->id) }}"
                                class="text-indigo-500 text-sm hover:underline">Edit</a>

                            <form action="{{ route('user.wallet.destroy', $wallet->id) }}" method="POST"
                                onsubmit="return confirm('Hapus wallet {{ $wallet->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mt-3">{{ $wallet->currency }}</p>

                    <h2 class="text-xl font-bold mt-1">
                        Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                    </h2>

                </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 py-12">
                    <p class="text-4xl mb-2">👜</p>
                    <p>Belum ada wallet. <a href="{{ route('user.wallet.create') }}"
                            class="text-indigo-500 hover:underline">Tambah sekarang</a></p>
                </div>
            @endforelse

        </div>

    </div>

</x-app-layout>
