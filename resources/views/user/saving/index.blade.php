{{-- resources/views/user/saving/index.blade.php --}}

<x-app-layout title="Target Tabungan">

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Target Tabungan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola target dan progress tabungan kamu
                </p>

            </div>

            <a href="{{ route('user.saving.create') }}"
                class="inline-flex items-center justify-center
                bg-indigo-600 hover:bg-indigo-700
                text-white px-5 py-3 rounded-xl
                text-sm font-medium transition shadow-sm">

                + Tambah Target
            </a>

        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- EMPTY --}}
        @if ($savings->count() < 1)

            <div class="bg-white border border-dashed border-gray-300 rounded-2xl p-12 text-center">

                <h3 class="text-lg font-semibold text-gray-700">
                    Belum ada target tabungan
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Buat target tabungan pertama kamu
                </p>

            </div>
        @else
            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($savings as $saving)
                    @php
                        $percentage = 0;

                        if ($saving->target_amount > 0) {
                            $percentage = ($saving->saved_amount / $saving->target_amount) * 100;
                        }

                        $percentage = min($percentage, 100);
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        {{-- TITLE --}}
                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $saving->name }}
                                </h3>

                                <p class="text-sm text-gray-400 mt-1">
                                    Target:
                                    Rp {{ number_format($saving->target_amount, 0, ',', '.') }}
                                </p>

                            </div>

                            <span
                                class="bg-indigo-100 text-indigo-600
                                text-xs font-semibold px-3 py-1 rounded-full">

                                {{ number_format($percentage, 0) }}%
                            </span>

                        </div>

                        {{-- PROGRESS --}}
                        <div class="mt-6">

                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

                                <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%">

                                </div>

                            </div>

                            <div class="flex items-center justify-between mt-3 text-sm">

                                <span class="text-gray-500">
                                    Terkumpul
                                </span>

                                <span class="font-semibold text-gray-700">
                                    Rp {{ number_format($saving->saved_amount, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>

                        {{-- TARGET DATE --}}
                        @if ($saving->target_date)
                            <div class="mt-5 text-sm text-gray-500">

                                Target:
                                {{ $saving->target_date->format('d M Y') }}

                            </div>
                        @endif

                        {{-- ACTION --}}
                        <div class="flex items-center gap-3 mt-6">

                            <a href="{{ route('user.saving.show', $saving->id) }}"
                                class="flex-1 text-center px-4 py-2 rounded-xl
                                bg-gray-100 hover:bg-gray-200
                                text-gray-700 text-sm font-medium transition">

                                Detail
                            </a>

                            <a href="{{ route('user.saving.edit', $saving->id) }}"
                                class="flex-1 text-center px-4 py-2 rounded-xl
                                bg-indigo-600 hover:bg-indigo-700
                                text-white text-sm font-medium transition">

                                Edit
                            </a>

                            <form action="{{ route('user.saving.destroy', $saving->id) }}" method="POST"
                                onsubmit="return confirm('Hapus target tabungan ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-4 py-2 rounded-xl
                                    bg-red-100 hover:bg-red-200
                                    text-red-600 text-sm font-medium transition">

                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div>
                {{ $savings->links() }}
            </div>

        @endif

    </div>

</x-app-layout>
