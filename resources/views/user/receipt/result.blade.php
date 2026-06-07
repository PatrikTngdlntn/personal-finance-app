<x-app-layout title="Hasil OCR">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-2xl font-bold mb-4">
                Hasil OCR
            </h1>

            {{-- Gambar --}}
            <div class="mb-6">

                <img src="{{ asset('storage/' . $receipt->image_path) }}"
                    class="rounded-lg border w-full max-h-[500px] object-contain">

            </div>

            {{-- Nominal --}}
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-500">
                    Nominal Terdeteksi
                </label>

                <p class="text-2xl font-bold text-green-600">

                    Rp {{ number_format($receipt->ocr_amount ?? 0, 0, ',', '.') }}

                </p>

            </div>

            {{-- OCR TEXT --}}
            <div>

                <label class="block text-sm font-medium text-gray-500 mb-2">
                    Hasil OCR
                </label>

                <textarea rows="15" class="w-full border rounded-lg p-3 bg-gray-50" readonly>{{ $receipt->ocr_text }}</textarea>

            </div>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('user.receipt.create') }}" class="px-4 py-2 bg-gray-200 rounded-lg">

                Scan Lagi

            </a>

        </div>

    </div>

</x-app-layout>
