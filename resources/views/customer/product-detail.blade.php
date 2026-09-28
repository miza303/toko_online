<x-app-layout :title="$product->name">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('customer.catalog') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke katalog</a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4 bg-white rounded-lg shadow p-6">
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-80 object-cover rounded-lg">
                @else
                    <div class="w-full h-80 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">Tanpa Gambar</div>
                @endif
            </div>

            <div class="flex flex-col">
                <p class="text-sm text-gray-400">{{ $product->category->name ?? 'Umum' }}</p>
                <h1 class="text-2xl font-bold text-gray-800 mt-1">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-blue-700 mt-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <p class="text-gray-600 mt-4 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

                <p class="mt-4 text-sm {{ $product->stock > 0 ? 'text-gray-500' : 'text-red-500 font-medium' }}">
                    {{ $product->stock > 0 ? 'Stok tersedia: '.$product->stock.' unit' : 'Stok habis' }}
                </p>

                @auth
                    @if(auth()->user()->isCustomer())
                        @if($product->stock > 0)
                            <form method="POST" action="{{ route('customer.cart.add', $product) }}" class="mt-6 flex gap-3">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-24 border border-gray-300 rounded-md px-3 py-2 text-sm">
                                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md font-medium hover:bg-blue-700">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button disabled class="mt-6 bg-gray-200 text-gray-400 px-5 py-2 rounded-md font-medium w-fit cursor-not-allowed">Stok Habis</button>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}" class="mt-6 inline-block bg-blue-600 text-white px-5 py-2 rounded-md font-medium hover:bg-blue-700 w-fit">
                        Masuk untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
