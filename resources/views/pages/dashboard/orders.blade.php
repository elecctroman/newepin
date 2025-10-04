<x-layouts.app title="My Orders">
    <h1 class="text-3xl font-bold mb-4">My Orders</h1>
    <div class="space-y-4">
        @foreach($orders as $order)
            <div class="bg-white shadow rounded p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">{{ $order->product->title }}</h2>
                        <p class="text-sm text-gray-500">Ref: {{ $order->reference }} · Status: {{ ucfirst($order->status) }}</p>
                    </div>
                    <span class="text-xl font-bold">${{ number_format($order->total_price, 2) }}</span>
                </div>
                @if($order->epins->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="font-semibold">Delivery</h3>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($order->epins as $pin)
                                <li>{{ $pin->code }} ({{ $pin->supplier_name }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</x-layouts.app>
