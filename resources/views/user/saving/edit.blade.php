{{-- resources/views/user/saving/edit.blade.php --}}

<x-app-layout title="Edit Target Tabungan">

    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- HEADER --}}
            <div class="mb-8">

                <h1 class="text-2xl font-bold text-gray-800">
                    Edit Target Tabungan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui target dan rencana tabungan kamu
                </p>

            </div>

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-4 rounded-2xl mb-6">

                    <ul class="list-disc ml-5 space-y-1 text-sm">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('user.saving.update', $saving->id) }}" class="space-y-6">

                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Target
                    </label>

                    <input type="text" name="name" value="{{ old('name', $saving->name) }}"
                        placeholder="Contoh: Dana Darurat"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                </div>

                {{-- TARGET AMOUNT --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Target Nominal
                    </label>

                    <input type="number" step="0.01" min="{{ $saving->saved_amount }}" name="target_amount"
                        value="{{ old('target_amount', $saving->target_amount) }}"
                        placeholder="Masukkan target tabungan"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                    <p class="text-xs text-gray-400 mt-2">
                        Minimal target harus lebih besar atau sama dengan saldo tabungan saat ini.
                    </p>

                </div>

                {{-- SAVED AMOUNT INFO --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4">

                    <p class="text-sm text-indigo-700">

                        Saldo tabungan saat ini:
                        <span class="font-bold">
                            Rp {{ number_format($saving->saved_amount, 0, ',', '.') }}
                        </span>

                    </p>

                </div>

                {{-- TARGET DATE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Target Tanggal
                    </label>

                    <input type="date" name="target_date"
                        value="{{ old('target_date', optional($saving->target_date)->format('Y-m-d')) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                </div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-end gap-3 pt-4">

                    <a href="{{ route('user.saving.index') }}"
                        class="px-5 py-3 rounded-xl border border-gray-200
                        text-gray-600 hover:bg-gray-100 transition">

                        Batal
                    </a>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700
                        text-white px-6 py-3 rounded-xl
                        font-medium transition shadow-sm">

                        Update Target
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
