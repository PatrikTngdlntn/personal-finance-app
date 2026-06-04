{{-- index.blade.php --}}

<x-app-layout title="Budgets">

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Budget Management
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola batas pengeluaran berdasarkan kategori
                </p>
            </div>

            <a href="{{ route('user.budget.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition">

                + Tambah Budget
            </a>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- LIST --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            @forelse ($budgets as $budget)
                <div class="p-5 border-b last:border-b-0">

                    <div class="flex items-start justify-between">

                        {{-- LEFT --}}
                        <div>

                            <h3 class="font-semibold text-gray-800 text-lg">
                                {{ $budget->category->name ?? '-' }}
                            </h3>

                            <div class="mt-2 space-y-1 text-sm text-gray-500">

                                <p>
                                    Limit:
                                    <span class="font-medium text-gray-700">
                                        Rp {{ number_format($budget->limit_amount, 0, ',', '.') }}
                                    </span>
                                </p>

                                <p>
                                    Periode:
                                    <span class="capitalize">
                                        {{ $budget->period }}
                                    </span>
                                </p>

                                <p>
                                    {{ \Carbon\Carbon::parse($budget->start_date)->format('d M Y') }}
                                    -
                                    {{ $budget->end_date ? \Carbon\Carbon::parse($budget->end_date)->format('d M Y') : '-' }}
                                </p>

                            </div>
                        </div>

                        {{-- RIGHT --}}
                        <div class="flex items-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('user.budget.edit', $budget->id) }}"
                                class="px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 text-sm transition">

                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('user.budget.destroy', $budget->id) }}" method="POST"
                                onsubmit="return confirm('Hapus budget ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-3 py-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 text-sm transition">

                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <p class="text-gray-400">
                        Belum ada budget
                    </p>

                </div>
            @endforelse

        </div>

    </div>

</x-app-layout>
