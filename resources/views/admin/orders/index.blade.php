<x-app-layout :title="'Histori Penjualan'">
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Histori Penjualan</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="text-sm">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->user->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->items->count() }} produk</td>
                            <td class="px-4 py-3 text-gray-800 font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">Belum ada penjualan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </div>
</x-app-layout>
