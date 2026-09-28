<x-app-layout :title="'Detail Order'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Detail Order {{ $order->order_number }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 space-y-2">
            <p class="text-sm"><span class="text-gray-500">Pembeli:</span> <strong>{{ $order->user->name }}</strong> ({{ $order->user->email }})</p>
            <p class="text-sm"><span class="text-gray-500">Alamat Pengiriman:</span> {{ $order->shipping_address }}</p>
            <p class="text-sm"><span class="text-gray-500">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p class="text-sm"><span class="text-gray-500">Status:</span> <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">{{ ucfirst($order->status) }}</span></p>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <tr class="text-sm">
                            <td class="px-4 py-2 text-gray-700">{{ $item->product_name }}</td>
                            <td class="px-4 py-2 text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-gray-800 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-700">Total</td>
                        <td class="px-4 py-3 font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
