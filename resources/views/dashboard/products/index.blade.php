<x-app-layout>


    <!-- Sidebar -->
    <x-sidebar-menu />


    <div class="lg:pl-64 pt-4"> {{-- pl-64 = offset sidebar, pt-16 = offset navbar/header --}}
        <div class="py-4 mx-auto sm:px-6 lg:px-8">

            <!-- Konten Utama -->
            <div class="mt-4 py-4 mx-auto bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
                    <a href="{{ route('dashboard.products.create') }}"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded">
                        + Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="max-w-full divide-y divide-gray-200 w-full border text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Gambar</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Kategori</th>

                                <th class="px-4 py-2 border">Deskripsi</th>
                                <th class="px-4 py-2 border">Harga</th>

                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $product->id }}</td>
                                    <td class="px-4 py-2 border">

                                        @if ($product->image)
                                            <img src="{{ asset('storage/products/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="h-24 w-full object-cover mb-4 rounded">
                                        @else
                                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center mb-4 rounded">
                                                <span class="text-gray-500">No Image</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border capitalize">{{ $product->name }}</td>
                                    <td class="px-4 py-2 border">{{ $product->category->name ?? '-' }}</td>

                                    <td class="px-4 py-2 border">{{ Str::limit($product->description, 30) }}</td>
                                    <td class="px-4 py-2 border">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        <div class="flex h-full gap-2 mx-auto">

                                            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="bg-orange-600 p-2 rounded-lg text-white">Edit</a>
                                            <form action="{{ route('dashboard.products.delete', $product->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 p-2 rounded-lg text-white">Hapus</button>
                                            </form>

                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-2 text-center text-gray-500">Tidak ada produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 my-4">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>


</x-app-layout>