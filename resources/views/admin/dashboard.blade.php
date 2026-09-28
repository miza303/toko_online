<x-app-layout :title="'Dashboard Penjual'">
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Penjual</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500">Total Stok</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalStock }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500">Total Order</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-semibold text-gray-800 mb-4">⚠️ Produk Stok Menipis</h2>
                @forelse($lowStockProducts as $product)
                    <div class="flex justify-between items-center py-2 border-b last:border-0">
                        <span class="text-sm text-gray-700">{{ $product->name }}</span>
                        <span class="text-sm font-semibold {{ $product->stock == 0 ? 'text-red-600' : 'text-orange-500' }}">{{ $product->stock }} unit</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Tidak ada produk dengan stok menipis.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-semibold text-gray-800 mb-4">🧾 Order Terbaru</h2>
                @forelse($recentOrders as $order)
                    <div class="flex justify-between items-center py-2 border-b last:border-0">
                        <div>
                            <p class="text-sm text-gray-700">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-400">{{ $order->user->name }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada order.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">📦 Histori Stok Terbaru</h2>
            @forelse($recentStockHistories as $history)
                <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                    <span class="text-gray-700">{{ $history->product->name ?? '-' }}</span>
                    <span class="{{ $history->quantity > 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                        {{ $history->quantity > 0 ? '+' : '' }}{{ $history->quantity }}
                    </span>
                    <span class="text-gray-400 text-xs">{{ $history->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada aktivitas stok.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
