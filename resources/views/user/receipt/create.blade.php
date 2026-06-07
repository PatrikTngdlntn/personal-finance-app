<x-app-layout title="Scan Receipt">

    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-2xl font-bold mb-2">
                Scan Struk
            </h1>

            <p class="text-gray-500 mb-6">
                Upload foto struk untuk diproses menggunakan OCR.
            </p>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.receipt.scan') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-4">

                    <label class="block mb-2 text-sm font-medium">
                        Upload Gambar Struk
                    </label>

                    <input type="file" name="receipt" accept="image/*" required class="w-full border rounded-lg p-3">

                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">

                    Scan OCR

                </button>

            </form>

        </div>

    </div>

</x-app-layout>
