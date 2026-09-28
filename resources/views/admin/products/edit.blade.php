<x-app-layout :title="'Edit Produk'">
    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                @include('admin.products._form')
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md font-medium hover:bg-blue-700">Perbarui Produk</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">
                Stok saat ini: <strong class="text-gray-800">{{ $product->stock }}</strong> unit.
                Untuk menambah stok, gunakan halaman
                <a href="{{ route('admin.stock.index', ['product_id' => $product->id]) }}" class="text-blue-600 hover:underline">Restok Stok</a>.
            </p>
        </div>
    </div>
</x-app-layout>
