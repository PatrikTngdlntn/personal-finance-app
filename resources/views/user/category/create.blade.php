<x-app-layout>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-sm">

        <h2 class="text-2xl font-bold mb-6">
            Tambah Kategori
        </h2>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.category.store') }}" method="POST" class="space-y-5">

            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm mb-2">
                    Nama Kategori
                </label>

                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Makanan"
                    class="w-full border rounded-lg px-4 py-3 focus:ring focus:ring-blue-200">
            </div>

            <!-- TYPE -->
            <div>
                <label class="block text-sm mb-2">
                    Type
                </label>

                <select name="type" class="w-full border rounded-lg px-4 py-3">

                    <option value="">-- pilih type --</option>

                    <option value="income">
                        Income
                    </option>

                    <option value="expense">
                        Expense
                    </option>

                </select>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('user.category.index') }}" class="px-4 py-2 rounded-lg border">
                    Batal
                </a>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</x-app-layout>
