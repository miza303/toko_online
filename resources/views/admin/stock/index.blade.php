<x-app-layout :title="'Restok Stok'">
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Restok Barang</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Stok Produk</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($products as $product)
                    <div class="border rounded-md p-4 flex flex-col gap-2">
                        <div class="flex justify-between items-start">
                            <span class="font-medium text-gray-800 text-sm">{{ $product->name }}</span>
                            <span class="text-xs {{ $product->stock <= 5 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">Stok: {{ $product->stock }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.stock.restock', $product) }}" class="flex gap-2">
                            @csrf
                            <input type="number" name="quantity" min="1" placeholder="Jumlah" required
                                class="w-24 border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <input type="text" name="note" placeholder="Catatan (opsional)"
                                class="flex-1 border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <button class="bg-blue-600 text-white px-3 py-1.5 rounded-md text-sm hover:bg-blue-700 whitespace-nowrap">+ Restok</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-800">Histori Stok</h2>
                <form method="GET" class="flex gap-2">
                    <select name="product_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-2 py-1.5 text-sm">
                        <option value="">Semua Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok Sebelum → Sesudah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Oleh</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($histories as $history)
                        <tr class="text-sm">
                            <td class="px-4 py-2 text-gray-700">{{ $history->product->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $history->type === 'restock' ? 'bg-green-100 text-green-700' : ($history->type === 'sale' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($history->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 {{ $history->quantity > 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                                {{ $history->quantity > 0 ? '+' : '' }}{{ $history->quantity }}
                            </td>
                            <td class="px-4 py-2 text-gray-500">{{ $history->stock_before }} → {{ $history->stock_after }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $history->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-400 text-xs">{{ $history->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">Belum ada histori.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $histories->links() }}
        </div>
    </div>
</x-app-layout>
