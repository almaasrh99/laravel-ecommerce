<x-app-layout>


    <!-- Sidebar -->
    <x-sidebar-menu />


    <div class="lg:pl-64 pt-4"> {{-- pl-64 = offset sidebar, pt-16 = offset navbar/header --}}
        <div class="py-4 mx-auto sm:px-6 lg:px-8">

            <!-- Konten Utama -->
            <div class="container mx-auto py-10">
                <h1 class="text-2xl font-semibold text-center">Detail Pesanan</h1>
                <div class="space-y-6 mt-6">
                    <div class="border border-gray-300 rounded-lg p-6">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="font-semibold">Order ID:</span> #{{ $order->id }}<br>
                                <span class="font-semibold">Tanggal:</span>
                                {{ $order->created_at->format('d M Y') }}<br>
                                <span class="font-semibold">Status:</span> <span
                                    class="text-orange-500">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div>
                                <span class="font-semibold">Nama:</span> {{ $order->user->name }}<br>
                                <span class="font-semibold">Email:</span> {{ $order->user->email }}<br>
                            </div>
                        </div>

                        <hr class="py-[2px] bg-slate-600">

                        <div class="space-y-4 my-4">
                            @foreach ($order->orderItems as $item)
                                <div class="flex justify-between border-b pb-2">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <span class="font-semibold">{{ $item->product->name }}</span><br>
                                            <span class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-semibold">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="my-4 flex justify-end">
                            <span class="font-semibold flex items-center justify-center gap-2">Total :</span>
                            <span class="text-indigo-600 font-semibold text-xl">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</x-app-layout>