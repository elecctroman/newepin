<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductManagementController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $product = new Product();

        return view('admin.products.create', compact('categories', 'product'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'type' => ['required', 'in:epin,account,license'],
            'price' => ['required', 'numeric'],
            'supplier' => ['required', 'in:turkpin,pinabi,manual'],
            'api_product_id' => ['nullable', 'string'],
            'stock_count' => ['required', 'integer'],
            'auto_deliver' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        Product::create(array_merge($data, [
            'slug' => Str::slug($data['title']),
            'auto_deliver' => (bool) ($data['auto_deliver'] ?? false),
        ]));

        return redirect()->route('admin.products.index')->with('status', 'Product created');
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'sku' => ['required', 'string', 'unique:products,sku,'.$product->id],
            'type' => ['required', 'in:epin,account,license'],
            'price' => ['required', 'numeric'],
            'supplier' => ['required', 'in:turkpin,pinabi,manual'],
            'api_product_id' => ['nullable', 'string'],
            'stock_count' => ['required', 'integer'],
            'auto_deliver' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $product->update(array_merge($data, [
            'slug' => Str::slug($data['title']),
            'auto_deliver' => (bool) ($data['auto_deliver'] ?? false),
        ]));

        return back()->with('status', 'Product updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product removed');
    }
}
