<x-app-layout :title="'Katalog Produk'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
            <p class="text-gray-500 text-sm mt-1">Temukan produk terbaik untuk kebutuhanmu.</p>
        </div>

        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                class="border border-gray-300 rounded-md px-3 py-2 text-sm flex-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <select name="category_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">Cari</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($products as $product)
                <a href="{{ route('customer.product.show', $product) }}" class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden flex flex-col">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">Tanpa Gambar</div>
                    @endif
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-xs text-gray-400">{{ $product->category->name ?? 'Umum' }}</p>
                        <h3 class="font-medium text-gray-800 mt-1 line-clamp-2">{{ $product->name }}</h3>
                        <div class="mt-auto pt-3 flex justify-between items-center">
                            <span class="font-bold text-blue-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs {{ $product->stock > 0 ? 'text-gray-400' : 'text-red-500 font-medium' }}">
                                {{ $product->stock > 0 ? 'Stok: '.$product->stock : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 text-sm col-span-full text-center py-10">Produk tidak ditemukan.</p>
            @endforelse
        </div>

        {{ $products->links() }}
    </div>
</x-app-layout>
