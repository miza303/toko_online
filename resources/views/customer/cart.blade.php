<x-app-layout :title="'Keranjang Belanja'">
    <div class="max-w-3xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h1>

        @if(count($items) === 0)
            <div class="bg-white rounded-lg shadow p-10 text-center text-gray-400">
                Keranjang kamu masih kosong.
                <div class="mt-3">
                    <a href="{{ route('customer.catalog') }}" class="text-blue-600 hover:underline text-sm">Mulai belanja →</a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow divide-y">
                @foreach($items as $item)
                    <div class="p-4 flex items-center gap-4">
                        @if($item['product']->image)
                            <img src="{{ asset('storage/'.$item['product']->image) }}" class="w-16 h-16 rounded object-cover">
                        @else
                            <div class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center text-gray-400 text-xs">N/A</div>
                        @endif

                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $item['product']->name }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($item['product']->price, 0, ',', '.') }} / unit</p>
                        </div>

                        <form method="POST" action="{{ route('customer.cart.update', $item['product']) }}" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}"
                                class="w-16 border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <button class="text-xs text-blue-600 hover:underline">Update</button>
                        </form>

                        <p class="font-semibold text-gray-800 w-28 text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>

                        <form method="POST" action="{{ route('customer.cart.remove', $item['product']) }}" onsubmit="return confirm('Hapus dari keranjang?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-sm">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Total Belanja</span>
                    <span class="text-2xl font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <form method="POST" action="{{ route('customer.checkout') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                        <textarea name="shipping_address" rows="2" required placeholder="Masukkan alamat lengkap pengiriman"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ auth()->user()->address }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-medium hover:bg-blue-700">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
