<x-app-layout :title="'Riwayat Belanja'">
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Belanja</h1>

        <div class="bg-white rounded-lg shadow divide-y">
            @forelse($orders as $order)
                <a href="{{ route('customer.orders.show', $order) }}" class="block p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }} · {{ $order->items->count() }} produk</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center text-gray-400">
                    Belum ada riwayat belanja.
                    <div class="mt-3"><a href="{{ route('customer.catalog') }}" class="text-blue-600 hover:underline text-sm">Mulai belanja →</a></div>
                </div>
            @endforelse
        </div>

        {{ $orders->links() }}
    </div>
</x-app-layout>
