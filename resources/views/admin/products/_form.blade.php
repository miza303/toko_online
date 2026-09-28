<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
    <select name="category_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Stok Awal {{ isset($product) ? '(tidak bisa diubah di sini)' : '' }}
        </label>
        <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
            {{ isset($product) ? 'readonly disabled' : 'required' }}
            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">SKU (opsional)</label>
    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
    @if(!empty($product) && $product->image)
        <img src="{{ asset('storage/'.$product->image) }}" class="w-20 h-20 rounded object-cover mb-2">
    @endif
    <input type="file" name="image" accept="image/*" class="w-full text-sm">
</div>

<label class="flex items-center gap-2 text-sm text-gray-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
    Produk aktif (ditampilkan ke pembeli)
</label>
