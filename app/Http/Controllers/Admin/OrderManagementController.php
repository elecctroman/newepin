<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\RetryFailedDeliveryJob;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderManagementController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user', 'product')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('epins', 'payment');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Order $order): RedirectResponse
    {
        $order->update(['status' => request('status', 'processing')]);

        if ($order->status === 'failed') {
            RetryFailedDeliveryJob::dispatch($order->id);
        }

        return back()->with('status', 'Order updated');
    }
}
