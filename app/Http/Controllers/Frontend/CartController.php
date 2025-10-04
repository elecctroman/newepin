<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = Session::get('cart', []);

        return view('pages.cart.index', compact('cart'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            'product' => $product,
            'quantity' => $data['quantity'],
        ];

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('status', 'Product added to cart');
    }

    public function destroy(string $productId): RedirectResponse
    {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return back()->with('status', 'Removed from cart');
    }
}
