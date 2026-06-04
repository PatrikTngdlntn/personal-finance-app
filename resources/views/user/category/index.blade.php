<x-app-layout>

    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Kategori
                </h1>

                <p class="text-gray-500 text-sm">
                    Kelola kategori pemasukan dan pengeluaran
                </p>
            </div>

            <a href="{{ route('user.category.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Tambah Kategori
            </a>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4">Nama</th>
                        <th class="text-left px-6 py-4">Type</th>
                        <th class="text-right px-6 py-4">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)
                        <tr class="border-t">

                            <td class="px-6 py-4 font-medium">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-4">

                                @if ($category->type === 'income')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Income
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Expense
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <!-- EDIT -->
                                    <a href="{{ route('user.category.edit', $category->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm">
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('user.category.destroy', $category->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Hapus kategori ini?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center py-10 text-gray-400">
                                Belum ada kategori
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
