@props(['title' => 'Toko Online'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Toko Online' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#2563eb',
                            600: '#1d4ed8', 700: '#1e40af',
                        }
                    }
                }
            }
        }
    </script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.catalog') }}" class="text-xl font-bold text-brand-700">
                        🛒 Toko Online
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="hidden md:flex gap-1">
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Dashboard</a>
                                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Produk</a>
                                <a href="{{ route('admin.stock.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.stock.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Restok Stok</a>
                                <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Histori Penjualan</a>
                            </div>
                        @else
                            <div class="hidden md:flex gap-1">
                                <a href="{{ route('customer.catalog') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('customer.catalog') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Katalog</a>
                                <a href="{{ route('customer.orders.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('customer.orders.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-100' }}">Riwayat Belanja</a>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('customer.cart.index') }}" class="relative px-3 py-2 text-gray-600 hover:text-brand-700">
                                🛍️ Keranjang
                                @php $cartCount = collect(session('cart', []))->sum(); @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                                @endif
                            </a>
                        @endif

                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-700 px-3 py-2 rounded-md hover:bg-gray-100">
                                {{ auth()->user()->name }}
                                <span class="text-xs bg-gray-200 rounded px-1.5 py-0.5">{{ auth()->user()->isAdmin() ? 'Penjual' : 'Pembeli' }}</span>
                            </button>
                            <div class="absolute right-0 mt-1 w-44 bg-white border rounded-md shadow-lg hidden group-hover:block z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-brand-700">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-brand-600 text-white rounded-md hover:bg-brand-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-white border-t py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Toko Online. Dibuat dengan Laravel.
    </footer>
</body>
</html>
