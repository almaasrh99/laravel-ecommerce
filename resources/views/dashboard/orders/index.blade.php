<x-app-layout>


    <!-- Sidebar -->
    <x-sidebar-menu />


    <div class="lg:pl-64 pt-4"> {{-- pl-64 = offset sidebar, pt-16 = offset navbar/header --}}
        <div class="py-4 mx-auto sm:px-6 lg:px-8">

            <!-- Konten Utama -->
            <div class="mt-4 py-4 mx-auto bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Order User</h2>
                    
                </div>

                <div class="overflow-x-auto">
                    <table class="max-w-full divide-y divide-gray-200 w-full border text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">ID Order</th>
                                <th class="px-4 py-2 border">Nama Pengguna </th>
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Aksi</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border">{{ $order->id }}</td>
                                   
                                    <td class="px-4 py-2 border capitalize">{{ $order->user->name }}</td>
                                  
                                    <td class="px-4 py-2 border">Rp {{ number_format($order->total) }}
                                    </td>
                                      <td class="px-4 py-2 border"><span class="bg-orange-200 p-4 py-2 rounded-full text-gray-800 font-normal capitalize">{{ $order->status}}</span></td>

                                    <td class="px-4 py-2 border">
                                        <div class="flex gap-2 justify-center mx-auto">

                                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="bg-blue-600 hover:bg-blue-800 p-2 rounded-lg text-white">Detail</a>
                                            <form action="{{ route('dashboard.orders.delete', $order->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus order ini?')">
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
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>


</x-app-layout>