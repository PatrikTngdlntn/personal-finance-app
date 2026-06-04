{{-- edit.blade.php --}}

<x-app-layout title="Edit Budget">

    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Budget
            </h1>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">

                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <form action="{{ route('user.budget.update', $budget->id) }}" method="POST" class="space-y-5">

                @csrf
                @method('PUT')

                {{-- CATEGORY --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>

                    <select name="category_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $budget->category_id == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- LIMIT --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Limit Budget
                    </label>

                    <input type="number" name="limit_amount" value="{{ $budget->limit_amount }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                {{-- PERIOD --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Periode
                    </label>

                    <select name="period"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        <option value="monthly" {{ $budget->period === 'monthly' ? 'selected' : '' }}>
                            Monthly
                        </option>

                        <option value="weekly" {{ $budget->period === 'weekly' ? 'selected' : '' }}>
                            Weekly
                        </option>

                        <option value="yearly" {{ $budget->period === 'yearly' ? 'selected' : '' }}>
                            Yearly
                        </option>

                    </select>
                </div>

                {{-- START DATE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date" name="start_date" value="{{ $budget->start_date?->format('Y-m-d') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                {{-- END DATE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Berakhir
                    </label>

                    <input type="date" name="end_date" value="{{ $budget->end_date?->format('Y-m-d') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                {{-- BUTTON --}}
                <div class="flex items-center gap-3 pt-4">

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-medium transition">

                        Update Budget
                    </button>

                    <a href="{{ route('user.budget.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">

                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
