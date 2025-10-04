<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(private PaymentGatewayManager $payments)
    {
    }

    public function index(): View
    {
        $cart = Session::get('cart', []);

        return view('pages.checkout.index', compact('cart'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = collect(Session::get('cart', []));

        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'Your cart is empty']);
        }

        $paymentMethod = $request->validate([
            'payment_method' => ['required', 'in:shopier,iyzico,paytr,wallet'],
        ])['payment_method'];

        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $cart->first()['product']->id,
            'quantity' => $cart->first()['quantity'],
            'total_price' => $cart->reduce(fn ($carry, $item) => $carry + ($item['product']->price * $item['quantity']), 0),
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'reference' => Str::uuid()->toString(),
        ]);

        if ($paymentMethod === 'wallet') {
            $order->update(['status' => 'paid']);
            event(new OrderPaid($order));
            Session::forget('cart');

            return redirect()->route('dashboard.orders')->with('status', 'Order placed successfully');
        }

        $payment = $this->payments->create($order, $paymentMethod);
        Session::forget('cart');

        return redirect()->away($payment['redirect_url']);
    }
}
