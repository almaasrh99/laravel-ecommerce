<x-app-layout>


    <!-- Sidebar -->
    <x-sidebar-menu />

    <!-- Konten Utama -->
    <div class="lg:pl-64 pt-16"> {{-- pl-64 = offset sidebar, pt-16 = offset navbar/header --}}
        <div class="py-6 mx-auto sm:px-6 lg:px-8">
            <div class="py-4 grid grid-cols-3 gap-4">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Total Produk</h2>
                        <p class="text-xl font-semibold">{{ $totalProducts }} </p>

                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Kategori</h2>
                        <p class="text-xl font-semibold">{{ $totalCategories }} </p>

                    </div>
                </div>
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Total Users</h2>
                        <p class="text-xl font-semibold">{{ $totalUsers }} </p>

                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
                        <p class="text-3xl font-normal">Selamat datang di halaman dashboard!</p>
                    </div>
                </div>
            </div>

</x-app-layout>
