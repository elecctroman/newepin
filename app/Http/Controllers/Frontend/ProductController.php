<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($category = $request->get('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        $product->load('reviews');

        return view('pages.products.show', compact('product'));
    }
}
