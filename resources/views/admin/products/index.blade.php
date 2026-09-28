<x-app-layout :title="'Kelola Produk'">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Produk</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 text-center">
                + Tambah Produk
            </a>
        </div>

        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full sm:w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-900">Cari</button>
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" class="w-10 h-10 rounded object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">N/A</div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-800">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm {{ $product->stock <= 5 ? 'text-red-600 font-semibold' : 'text-gray-600' }}">{{ $product->stock }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-sm space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
</x-app-layout>
