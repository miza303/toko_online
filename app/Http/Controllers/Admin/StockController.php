<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('name')->get();

        $historiesQuery = StockHistory::with('product', 'user')->latest();

        if ($productId = $request->get('product_id')) {
            $historiesQuery->where('product_id', $productId);
        }

        $histories = $historiesQuery->paginate(15)->withQueryString();

        return view('admin.stock.index', compact('products', 'histories'));
    }

    public function restock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $product, $request) {
            $stockBefore = $product->stock;
            $product->increment('stock', $validated['quantity']);

            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'restock',
                'quantity' => $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockBefore + $validated['quantity'],
                'note' => $validated['note'] ?? 'Restok barang',
            ]);
        });

        return redirect()->route('admin.stock.index')->with('success', "Stok produk \"{$product->name}\" berhasil ditambahkan.");
    }
}
