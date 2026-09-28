<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    const SESSION_KEY = 'cart';

    public function index()
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }
            $subtotal = $product->price * $qty;
            $total += $subtotal;
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        return view('customer.cart', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $cart = Session::get(self::SESSION_KEY, []);

        $currentQty = $cart[$product->id] ?? 0;
        $newQty = $currentQty + $quantity;

        if ($newQty > $product->stock) {
            return back()->with('error', "Stok \"{$product->name}\" tidak mencukupi. Stok tersedia: {$product->stock}.");
        }

        $cart[$product->id] = $newQty;
        Session::put(self::SESSION_KEY, $cart);

        return back()->with('success', "\"{$product->name}\" ditambahkan ke keranjang.");
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity');

        if ($quantity > $product->stock) {
            return back()->with('error', "Stok \"{$product->name}\" tidak mencukupi. Stok tersedia: {$product->stock}.");
        }

        $cart = Session::get(self::SESSION_KEY, []);
        $cart[$product->id] = $quantity;
        Session::put(self::SESSION_KEY, $cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = Session::get(self::SESSION_KEY, []);
        unset($cart[$product->id]);
        Session::put(self::SESSION_KEY, $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
