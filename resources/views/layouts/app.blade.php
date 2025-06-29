<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="h-16 flex items-center justify-center border-b font-bold text-xl text-blue-800">
                JKStore
            </div>
        
            <!-- Navigasi & Menu -->
            <div class="flex-1 flex flex-col justify-between">
                <!-- Menu utama -->
                <nav class="px-4 py-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                        Dashboard
                    </a>
        
                    @if(auth()->user()->isAdmin)
                        <a href="{{ url('admin/toko') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/toko*') ? 'bg-gray-200 font-semibold' : '' }}">
                            Toko
                        </a>
                        <a href="{{ url('admin/users') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/users*') ? 'bg-gray-200 font-semibold' : '' }}">
                            User
                        </a>
                    @endif
        
                    <a href="{{ auth()->user()->isAdmin ? url('admin/barang') : url('gudang/barang') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('*/barang*') ? 'bg-gray-200 font-semibold' : '' }}">
                        Barang
                    </a>
        
                    <a href="{{ auth()->user()->isAdmin ? url('admin/purchase') : url('gudang/purchase') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('*/purchase*') ? 'bg-gray-200 font-semibold' : '' }}">
                        Purchase
                    </a>
        
                    <a href="{{ auth()->user()->isAdmin ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}" class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('*/stok-keluar*') ? 'bg-gray-200 font-semibold' : '' }}">
                        Stok Keluar
                    </a>
                </nav>
        
                <!-- User info dan logout -->
                <div class="px-4 py-6 border-t">
                    <a href="{{ auth()->user()->isAdmin ? url('admin/profile') : url('gudang/profile') }}"
                        class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->is('*/profile*') ? 'bg-gray-200 font-semibold' : '' }}">
                        {{ auth()->user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-3 py-2 rounded hover:bg-red-100 text-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>        

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Page Header -->
            <header class="bg-white shadow p-5">
                <div class="text-xl font-semibold text-gray-800">
                    {{ $header ?? '' }}
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @if(session('success') || session('error'))
    <div id="notification-toast" class="fixed top-5 right-5 z-50 px-4 py-3 rounded shadow-lg text-white
        {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
        {{ session('success') ?? session('error') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('notification-toast');
            if (toast) toast.style.display = 'none';
        }, 2000); // 2 detik
    </script>
    @endif
</body>
</html>
