<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock')->get();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $recentOrders = Order::with('user', 'items')->latest()->take(5)->get();
        $recentStockHistories = StockHistory::with('product', 'user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'recentStockHistories'
        ));
    }
}
