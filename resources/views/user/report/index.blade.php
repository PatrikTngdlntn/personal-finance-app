<x-app-layout title="Financial Report">

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Financial Report
            </h1>

            <p class="text-slate-500 mt-1">
                Ringkasan aktivitas keuangan bulanan
            </p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">

            <form method="GET" class="flex flex-wrap gap-3 items-center">

                <select name="month" class="border border-slate-300 rounded-xl px-4 py-2">

                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor

                </select>

                <select name="year" class="border border-slate-300 rounded-xl px-4 py-2">

                    @for ($i = now()->year; $i >= 2024; $i--)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor

                </select>

                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl">

                    Filter

                </button>

            </form>

        </div>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <div class="bg-white rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">
                    Income
                </p>

                <h2 class="text-2xl font-bold text-green-600 mt-2">
                    Rp {{ number_format($income, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">
                    Expense
                </p>

                <h2 class="text-2xl font-bold text-red-600 mt-2">
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">
                    Subscription
                </p>

                <h2 class="text-2xl font-bold text-orange-500 mt-2">
                    Rp {{ number_format($subscriptionExpense, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">
                    Saving
                </p>

                <h2 class="text-2xl font-bold text-cyan-600 mt-2">
                    Rp {{ number_format($savingExpense, 0, ',', '.') }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-5">
                <p class="text-sm text-slate-500">
                    Net Cash Flow
                </p>

                <h2 class="text-2xl font-bold text-indigo-600 mt-2">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </h2>
            </div>

        </div>

        {{-- EXPENSE CATEGORY --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-bold text-lg mb-4">
                Expense by Category
            </h2>

            <table class="w-full">

                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Category</th>
                        <th class="text-right py-3">Amount</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categorySummary as $item)
                        <tr class="border-b">

                            <td class="py-3">
                                {{ $item->category->name ?? '-' }}
                            </td>

                            <td class="py-3 text-right font-medium">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="2" class="py-4 text-center text-slate-500">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- SUBSCRIPTION --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-bold text-lg mb-4">
                Subscription Report
            </h2>

            <table class="w-full">

                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Subscription</th>
                        <th class="text-left py-3">Billing Date</th>
                        <th class="text-right py-3">Amount</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($subscriptions as $subscription)
                        <tr class="border-b">

                            <td class="py-3">
                                {{ $subscription->name }}
                            </td>

                            <td class="py-3">
                                {{ $subscription->next_billing }}
                            </td>

                            <td class="py-3 text-right">
                                Rp {{ number_format($subscription->amount, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="py-4 text-center text-slate-500">
                                Tidak ada subscription
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- SAVING --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-bold text-lg mb-4">
                Saving Report
            </h2>

            <table class="w-full">

                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Saving</th>
                        <th class="text-right py-3">Total Deposit</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($savingSummary as $saving)
                        <tr class="border-b">

                            <td class="py-3">
                                {{ $saving->saving->name ?? '-' }}
                            </td>

                            <td class="py-3 text-right">
                                Rp {{ number_format($saving->total, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="2" class="py-4 text-center text-slate-500">
                                Tidak ada data saving
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- TRANSACTION --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-bold text-lg mb-4">
                Transaction History
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">Date</th>
                            <th class="text-left py-3">Type</th>
                            <th class="text-left py-3">Category</th>
                            <th class="text-right py-3">Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($transactions as $transaction)
                            <tr class="border-b">

                                <td class="py-3">
                                    {{ $transaction->transaction_date }}
                                </td>

                                <td class="py-3">
                                    {{ ucfirst($transaction->type) }}
                                </td>

                                <td class="py-3">
                                    {{ $transaction->category->name ?? '-' }}
                                </td>

                                <td class="py-3 text-right">

                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
