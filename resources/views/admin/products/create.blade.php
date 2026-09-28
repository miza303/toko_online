<x-app-layout :title="'Tambah Produk'">
    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Produk</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @include('admin.products._form')
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md font-medium hover:bg-blue-700">Simpan Produk</button>
            </form>
        </div>
    </div>
</x-app-layout>
