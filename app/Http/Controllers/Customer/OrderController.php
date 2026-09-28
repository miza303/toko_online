<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Checkout langsung: keranjang -> order, stok otomatis berkurang.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'max:255'],
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang belanja masih kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $validated, $request) {
                $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get()->keyBy('id');
                $total = 0;

                // Validasi stok dulu sebelum proses apapun
                foreach ($cart as $productId => $qty) {
                    $product = $products->get($productId);
                    if (! $product) {
                        throw new \Exception('Salah satu produk di keranjang sudah tidak tersedia.');
                    }
                    if ($qty > $product->stock) {
                        throw new \Exception("Stok \"{$product->name}\" tidak mencukupi (tersedia: {$product->stock}).");
                    }
                    $total += $product->price * $qty;
                }

                $order = Order::create([
                    'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                    'user_id' => $request->user()->id,
                    'total_price' => $total,
                    'status' => 'completed',
                    'shipping_address' => $validated['shipping_address'],
                ]);

                foreach ($cart as $productId => $qty) {
                    $product = $products->get($productId);
                    $stockBefore = $product->stock;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $qty,
                        'subtotal' => $product->price * $qty,
                    ]);

                    // Stok otomatis berkurang
                    $product->decrement('stock', $qty);

                    StockHistory::create([
                        'product_id' => $product->id,
                        'user_id' => $request->user()->id,
                        'type' => 'sale',
                        'quantity' => -$qty,
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockBefore - $qty,
                        'note' => "Terjual pada order {$order->order_number}",
                    ]);
                }

                return $order;
            });
        } catch (\Exception $e) {
            return redirect()->route('customer.cart.index')->with('error', $e->getMessage());
        }

        Session::forget('cart');

        return redirect()->route('customer.orders.show', $order)->with('success', 'Checkout berhasil! Pesanan kamu sedang diproses.');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }
}
