<x-app-layout title="Admin Dashboard">

    <div class="space-y-6">

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Users</p>
                <h2 class="text-3xl font-bold mt-2 text-indigo-600">{{ $totalUsers }}</h2>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <h2 class="text-3xl font-bold mt-2 text-blue-600">{{ $totalTransactions }}</h2>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Wallet</p>
                <h2 class="text-3xl font-bold mt-2 text-green-600">{{ $totalWallets }}</h2>
            </div>

        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">Anda login sebagai <span class="font-semibold text-indigo-600">Admin</span>.</p>
        </div>

    </div>

</x-app-layout>
