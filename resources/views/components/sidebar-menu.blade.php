<div x-data="{ open: false }">
    <!-- Toggle Button (Mobile) -->
    <button @click="open = !open" class="p-4 lg:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar -->
    <aside
        :class="{ 'block': open, 'hidden': !open }"
        class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 hidden lg:block z-20"
    >
        <div class="p-4 pt-20">
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white text-gray-700
                   {{ request()->routeIs('dashboard') ? 'bg-blue-500 font-semibold text-white' : '' }}">
                    <i class="fa fa-home w-5"></i> Dashboard
                </a>
                <a href="{{ route('dashboard.products') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white text-gray-700
                   {{ request()->routeIs('dashboard.products') ? 'bg-blue-500 font-semibold text-white hover:none' : '' }}">
                    <i class="fa fa-box w-5"></i> Products
                </a>
                <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white text-gray-700
                {{ request()->routeIs('dashboard.categories') ? 'bg-blue-500 font-semibold text-white' : '' }}">
                    <i class="fa-solid fa-rectangle-list w-5"></i> Categories
                </a>
                <a href="{{ route('dashboard.orders') }}"
                class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white text-gray-700
                {{ request()->routeIs('dashboard.orders') ? 'bg-blue-500 font-semibold text-white' : '' }}">
                    <i class="fa fa-boxes-stacked w-5"></i> Orders
                </a>
                <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white text-gray-700
                {{ request()->routeIs('dashboard.users') ? 'bg-blue-500 font-semibold text-white' : '' }}">
                    <i class="fa fa-user w-5"></i> Users
                </a>
               

                <a href="#"
                class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500  hover:text-white text-gray-700
                {{ request()->routeIs('dashboard.logout') ? 'bg-blue-500 font-semibold text-white' : '' }}">
                    <i class="fa fa-sign-out w-5"></i> Logout
                </a>
            </nav>
        </div>
    </aside>
</div>
