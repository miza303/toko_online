<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true)->latest();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('customer.catalog', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('customer.product-detail', compact('product'));
    }
}
