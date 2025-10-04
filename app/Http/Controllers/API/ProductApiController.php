<?php

namespace App\Http\Controllers\API;

use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    public function __construct(private PaymentGatewayManager $payments)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $products = Product::query()
            ->when($request->get('category'), fn ($query, $category) => $query->whereHas('category', fn ($q) => $q->where('slug', $category)))
            ->paginate();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:shopier,iyzico,paytr,wallet'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $product->price * $validated['quantity'],
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'reference' => Str::uuid()->toString(),
        ]);

        if ($validated['payment_method'] === 'wallet') {
            $order->update(['status' => 'paid']);
            event(new OrderPaid($order));

            return response()->json(['order' => $order, 'message' => 'Wallet payment accepted']);
        }

        $payment = $this->payments->create($order, $validated['payment_method']);

        return response()->json(['order' => $order, 'payment' => $payment]);
    }

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json($order->load('epins'));
    }
}
