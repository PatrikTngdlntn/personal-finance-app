<x-app-layout title="Subscriptions">

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Subscription
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola tagihan langganan dan pembayaran otomatis
                </p>
            </div>

            <a href="{{ route('user.subscription.create') }}"
                class="inline-flex items-center justify-center gap-2
                bg-indigo-600 hover:bg-indigo-700
                text-white px-5 py-3 rounded-xl
                text-sm font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                </svg>

                Tambah Subscription
            </a>

        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-200
                text-green-700 px-4 py-3 rounded-xl text-sm">

                {{ session('success') }}

            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 border-b border-gray-100">

                        <tr class="text-left text-gray-500">

                            <th class="px-6 py-4 font-medium">
                                Nama
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Wallet
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Billing
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Jatuh Tempo
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Status
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Harga
                            </th>

                            <th class="px-6 py-4 font-medium text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- NAME --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-gray-800">
                                        {{ $subscription->name }}
                                    </div>

                                </td>

                                {{-- WALLET --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $subscription->wallet?->name ?? '-' }}

                                </td>

                                {{-- BILLING --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium
                                        bg-indigo-100 text-indigo-600">

                                        {{ $subscription->billingCycleLabel() }}

                                    </span>

                                </td>

                                {{-- NEXT BILLING --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $subscription->next_billing->format('d M Y') }}

                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">

                                    @if ($subscription->isDue())
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            bg-red-100 text-red-600">

                                            Jatuh Tempo
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            bg-green-100 text-green-600">

                                            Aktif
                                        </span>
                                    @endif

                                </td>

                                {{-- AMOUNT --}}
                                <td class="px-6 py-4 font-semibold text-gray-800">

                                    {{ $subscription->currency }}
                                    {{ number_format($subscription->amount, 0, ',', '.') }}

                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- PAY --}}
                                        @if ($subscription->isDue())
                                            <form method="POST"
                                                action="{{ route('user.subscription.pay', $subscription->id) }}">

                                                @csrf

                                                <button type="submit"
                                                    class="inline-flex items-center gap-1
                                                       px-3 py-2 rounded-lg
                                                       bg-green-100 hover:bg-green-200
                                                       text-green-700 text-xs font-medium transition">

                                                    Bayar

                                                </button>

                                            </form>
                                        @endif

                                        {{-- EDIT --}}
                                        <a href="{{ route('user.subscription.edit', $subscription->id) }}"
                                            class="inline-flex items-center gap-1
                                            px-3 py-2 rounded-lg
                                            bg-yellow-100 hover:bg-yellow-200
                                            text-yellow-700 text-xs font-medium transition">

                                            Edit
                                        </a>

                                        {{-- DELETE --}}
                                        <form method="POST"
                                            action="{{ route('user.subscription.destroy', $subscription->id) }}"
                                            onsubmit="return confirm('Hapus subscription ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center gap-1
                                                px-3 py-2 rounded-lg
                                                bg-red-100 hover:bg-red-200
                                                text-red-600 text-xs font-medium transition">

                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-12 text-center">

                                    <div class="flex flex-col items-center justify-center">

                                        <div
                                            class="w-16 h-16 rounded-full
                                            bg-gray-100 flex items-center justify-center mb-4">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
                                                    3-1.343 3-3-1.343-3-3-3zm0-6v2m0
                                                    16v2m8-10h2M2 12H4m12.95 6.95l1.414
                                                    1.414M5.636 5.636L7.05 7.05m0
                                                    9.9l-1.414 1.414M18.364 5.636L16.95 7.05" />
                                            </svg>

                                        </div>

                                        <h3 class="text-base font-semibold text-gray-700">
                                            Belum ada subscription
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Tambahkan subscription pertama kamu
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}
        <div>

            {{ $subscriptions->links() }}

        </div>

    </div>

</x-app-layout>
