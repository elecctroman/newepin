<x-layouts.app title="Admin Dashboard">
    <h1 class="text-3xl font-bold mb-4">Admin Overview</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-sm text-gray-500 uppercase">Users</h2>
            <p class="text-2xl font-semibold">{{ $stats['users'] }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-sm text-gray-500 uppercase">Orders</h2>
            <p class="text-2xl font-semibold">{{ $stats['orders'] }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-sm text-gray-500 uppercase">Revenue</h2>
            <p class="text-2xl font-semibold">${{ number_format($stats['revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-sm text-gray-500 uppercase">Products</h2>
            <p class="text-2xl font-semibold">{{ $stats['products'] }}</p>
        </div>
    </div>
    <section class="mt-8">
        <h2 class="text-xl font-semibold mb-3">Recent Orders</h2>
        <div class="space-y-2">
            @foreach($recentOrders as $order)
                <div class="bg-white rounded shadow p-4 flex justify-between">
                    <div>
                        <p class="font-semibold">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->product->title }}</p>
                    </div>
                    <span>{{ ucfirst($order->status) }}</span>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
